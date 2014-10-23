<?php

/**
 * This file does some basic moving/renaming of already-validated files. Validation is done in a separate class, so files are
 * assumed to be of the MIME type they appear to be.
 *
 * Written by Tom Lagier
 */

class FileHelper {
	public static function prepFiles(&$data)
	{
		if($data['attachment_1'] !== null || $data['attachment_2'] !== null || $data['attachment_3'] !== null || $data['attachment_4'] !== null)
		{
			$data['files'] = array();

			$counter = 1;

			while ($counter <= 4)
			{
				$fileInput = 'attachment_' . $counter;

				if($data[$fileInput] !== null && $data[$fileInput] !== "" && isset($data[$fileInput]))
				{

					$path = FileHelper::moveFile($fileInput);
					$file = new Symfony\Component\HttpFoundation\File\File($path);
					$mime = $file->getMimeType();

					$fileData = array(
						'path' => $path,
						'mime' => $mime
					);
					$data['files'][] = $fileData;
				}

				$counter++;
			}
		}
	}

	public static function moveFile($fileInput)
	{
		$filename = uniqid('attachment_') . '.' . Input::file($fileInput)->getClientOriginalExtension();
		
		$destination = Input::file($fileInput)->move($_SERVER['DOCUMENT_ROOT'] . '/uploads/', $filename);

		return ($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $filename);
	}
}