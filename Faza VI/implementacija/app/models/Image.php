<?php

	class Image {

		function getImages($conn, $idOglas) {
			$sql = "SELECT id, Ime FROM slika WHERE idOglas = ?";	

			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $idOglas);
			if (!$stmt->execute()) throw new Exception("Nije uspelo dohvatanje slika za oglas (id: $idOglas).");
			$result = $stmt->get_result();

			return $result;
		}

		function uploadImages($conn, $img, $idOglas, $brslika = 0) {
			$n = count(array_filter($img['files']['name'])); 
			if ($n > 0) { 
				if ($n <= (9 - $brslika)) {
					for ($i = 0; $i < $n; $i++) { 
						$filename = $img['files']['name'][$i]; 
						if (move_uploaded_file($img['files']['tmp_name'][$i], "uploads/$filename")) { 
							$name = $this->image_resize_compress("uploads/$filename", "./oglasi/$idOglas/slike", 1920, 1080, 90); 
							$stmt1 = $conn->prepare("INSERT INTO slika (idOglas, Ime) VALUES (?, ?)");
							$stmt1->bind_param('is', $idOglas, $name);

							if (!$stmt1->execute()) throw new Exception("Umetanje slike u bazu nije uspelo");						
						} else throw new Exception("Upload slike nije uspeo");					
					} 
				}
				else throw new Exception("Nedozvoljen broj slika");			
			} else {
				if ($brslika == 0) {
					if (!copy($_SERVER['DOCUMENT_ROOT'] . "/psi/images/logoblack.png", $_SERVER['DOCUMENT_ROOT'] ."/psi/oglasi/$idOglas/slike/logoblack.png")) 
						throw new Exception("Upload slika nije uspeo");
				}
			}
		}

		function getNumberImages($conn, $idOglas) {
			$res = $this->getImages($conn, $idOglas);
			return ($res) ? $res->num_rows : 0;
		}

		function deleteImage($conn, $id, $idOglas) {
			
			$stmt = $conn->prepare("SELECT Ime FROM slika WHERE id = ?");
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($slika);
			$stmt->fetch();

			unlink($_SERVER['DOCUMENT_ROOT'] . "/psi/oglasi/$idOglas/slike/$slika");

			$stmt = $conn->prepare("DELETE FROM slika WHERE id = ?");
			$stmt->bind_param('i', $id);
			$ret = $stmt->execute();		

			return $ret;
		}

		function deleteAllImagesOfAd($conn, $idOglas) {

			$stmt = $conn->prepare("DELETE FROM slika WHERE idOglas = ?");
			$stmt->bind_param('i', $idOglas);
			if (!$stmt->execute()) throw new Exception("Brisanje svih slika oglasa nije uspelo.");
		}

		function deleteAllImagesFromAdIdArray($conn, $arr) {

			for($i = 0; $i < count($arr); $i++) {
				try {
					$this->deleteAllImagesOfAd($conn, $arr[$i]);
				} catch (Exception $e) {
					throw new Exception("Brisanje svih slika korisnika nakon 3 velika<br>prestupa nije uspelo.<br>" . $e->getMessage());					
				}
			}
		}

		function check_extension($file) {
			$allowed =  array('gif','png' ,'jpg', 'jpeg');
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			if(!in_array($ext,$allowed)) return false;
			else return true;
		}

		function image_resize_compress($img_src, $folder_dest, $max_width, $max_height, $compression) {
			$info = getimagesize($img_src);

			if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($img_src);
			elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($img_src);
			elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($img_src);

			unlink($img_src);

			$dst = $folder_dest."/";
			$return = time().uniqid(rand()).".jpg";
			$dst .= $return;

			$old_width = imagesx($image);
			$old_height = imagesy($image);
			if ($old_width > $max_width || $old_height > $old_height) {
				$scale = min($max_width/$old_width, $max_height/$old_height);
				$new_width = ceil($scale*$old_width);
				$new_height = ceil($scale*$old_height);

				$new_image = imagecreatetruecolor($new_width, $new_height);

				imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

				imagejpeg($new_image, $dst, $compression);

				imagedestroy($new_image);

			} else imagejpeg($image, $dst, $compression);

			imagedestroy($image);
			return $return;
		}
	}

?>