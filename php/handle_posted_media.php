<?php
	function extractFrame($video, $save_to) {
		//$tempFramePath = "./".preg_replace("/\.[^.]+$/", ".jpg", $video);
		$tempFramePath = "./$save_to".preg_replace("/\.[^.]+$/", "jpg", $video);

		$command = "ffmpeg -i ".escapeshellarg($video)." -ss 00:00:01.000 -vframes 1 ".escapeshellarg($tempFramePath)." -y";
		exec($command, $output, $returnCode);

		if ($returnCode !== 0)
			throw new Exception("Failed to extract frame from video. FFmpeg output: $output");

		return $tempFramePath;
	}

	function resizeImage($file, $videoes, $audio, $targetLen = 150) {
		foreach ($audio as $needle) {
			if (str_contains($file, $needle)) {
				exec("cp {$_SERVER['DOCUMENT_ROOT']}/assets/images/audio.png ".preg_replace("/(\d+)\..+/", '${1}_thumb.jpg', $file));
				return;
			}
		}
		$is_video = false;
		foreach ($videoes as $needle) {
			if (str_contains($file, $needle)) {
				$is_video = true;
				$file = extractFrame($file);
				break;
			}
		}
		list($oldW, $oldH, $imageType) = getimagesize($file);

		$scaleFactor = $targetLen / max($oldW, $oldH);
		$newW = round($oldW * $scaleFactor);
		$newH = round($oldH * $scaleFactor);

		switch ($imageType) {
			case IMAGETYPE_JPEG:
				$sourceImage = imagecreatefromjpeg($file);
				break;

			case IMAGETYPE_PNG:
				$sourceImage = imagecreatefrompng($file);
				break;

			case IMAGETYPE_GIF:
				$sourceImage = imagecreatefromgif($file);
				break;

			case IMAGETYPE_WEBP:
				$sourceImage = imagecreatefromwebp($file);
				break;
		}

		$resizedImage = imagecreatetruecolor($newW, $newH);

		if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
			imagealphablending($resizedImage, false);
			imagesavealpha($resizedImage, true);
		}

		imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newW, $newH, $oldW, $oldH);

		$outputFile = preg_replace('/(\d+)\.(\w+)$/', '${1}_thumb.${2}', $file);
		switch ($imageType) {
			case IMAGETYPE_JPEG:
				imagejpeg($resizedImage, $outputFile);
				break;

			case IMAGETYPE_PNG:
				imagepng($resizedImage, $outputFile);
				break;

			case IMAGETYPE_GIF:
				imagegif($resizedImage, $outputFile);
				break;

			case IMAGETYPE_WEBP:
				imagewebp($resizedImage, $outputFile);
		}

		imagedestroy($sourceImage);
		imagedestroy($resizedImage);

		if ($is_video)
			exec("rm ".escapeshellarg($file));

		return $outputFile;
	}

	function collectMetaData($file, $images, $audio, $videos) {
		$mimeToExt = [
			'image/jpeg'	=> 'jpg',
			'image/png'		=> 'png',
			'image/gif'		=> 'gif',
			'image/webp'	=> 'webp',
			'audio/mpeg'	=> 'mp3',
			'audio/ogg'		=> 'ogg',
			'video/mp4'		=> 'mp4',
			'video/webm'	=> 'webm'
		];

		$name = $file['name'];
		$type = $mimeToExt[$file['type']];
		$size = $file['size'];
		if (in_array($type, $images)) {
			$t_dim = getimagesize($file['tmp_name']);
			$dim = "{$t_dim[0]}x{$t_dim[1]}";
		} elseif (in_array($type, $videos)) {
			$v_frame = extractFrame($file['tmp_name'], "temp/place/");
			$t_dim = getimagesize($v_frame);
			exec("rm ".escapeshellarg($v_frame));
			$dim = "{$t_dim[0]}x{$t_dim[1]}";
		} else if (in_array($type, $audio)) {
			$dim = "";
		}
		return [$name, $type, $size, $dim];
	}
?>
