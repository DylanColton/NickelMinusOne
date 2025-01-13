<?php
	function extractFrame($video) {
		$tempFramePath = "./".preg_replace("/\.[^.]+$/", ".jpg", $video);

		$command = "ffmpeg -i ".escapeshellarg($video)." -ss 00:00:01.000 -vframes 1 ".escapeshellarg($tempFramePath)." -y";
		exec($command, $output, $returnCode);

		if ($returnCode !== 0)
			throw new Exception("Failed to extract frame from video. FFmpeg output: $output");

		return $tempFramePath;
	}

	function resizeImage($file, $videoes, $targetLen = 150) {
		$is_video = false;
		foreach ($videoes as $needle) {
			if (str_contains($file, $needle)) {
				$is_video = true;
				$file = extractFrame($file);
				break;
			}
		}
		list($oldW, $oldH, $imageType) = getimagesize("./$file");

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

			case IMAGE_TYPE_GIF:
				$sourceImage = imagecreatefromgif($file);
				break;
		}

		$resizedImage = imagecreatetruecolor($newW, $newH);

		if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
			imagealphablending($resizedImage, false);
			imagesavealpha($resizedImage, true);
		}

		imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newW, $newH, $oldW, $oldH);

		//$outputFile = preg_replace('\.^\/', '_thumb.', $file);
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
		}

		imagedestroy($sourceImage);
		imagedestroy($resizedImage);

		if ($is_video)
			exec("rm $file");

		return $outputFile;
	}
?>
