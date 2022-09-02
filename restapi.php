<?php 

/**
 * https://www.indonetsource.com/cara-membuat-rest-api-dengan-php-native-dan-mysql/
 */

include 'koneksi.php';

if(function_exists($_GET['function'])){
   $_GET['function']();
}

function get_karyawan(){
   global $koneksi;

   $query = $koneksi->query("SELECT * FROM karyawan");
   while($row = mysqli_fetch_object($query)){
      $data[] = $row;
   }

   $response = array(
      'status' => 1,
      'message' => 'Success',
      'data' => $data
   );

   header('Content-type: application/json');
   echo json_encode($response);
}

function get_karyawan_id(){
   global $koneksi;

   if(!empty($_GET['id'])){
      $id = $_GET['id'];
   }

   $query = $koneksi->query("SELECT * FROM karyawan WHERE id=$id");
   while($row = mysqli_fetch_object($query)){
      $data[] = $row;
   }

   if($data){
      $response = array(
         'status' => 1,
         'message' => 'Success',
         'data' => $data
      );
   }else{
      $response = array(
         'status' => 0,
         'message' => 'No Data Found'
      );
   }

   header('Content-type: application/json');
   echo json_encode($response);
}

function insert_karyawan(){
   global $koneksi;

   $check = array(
      'id' => '',
      'nama' => '',
      'jenis_kelamin' => '',
      'alamat' => ''
   );

   $check_match = count(array_intersect_key($_POST, $check));
   if($check_match == count($check)){

      $result = mysqli_query($koneksi, "
         INSERT INTO karyawan SET 
         id = '$_POST[id]',
         nama = '$_POST[nama]',
         jenis_kelamin = '$_POST[jenis_kelamin]',
         alamat = '$_POST[alamat]'
      ");

      if($result){
         $response = array(
            'status' => 1,
            'message' => 'Insert Success'
         );
      }else{
         $response = array(
            'status' => 0,
            'message' => 'Insert Failed'
         );
      }
   }else{
      $response = array(
         'status' => 0,
         'message' => 'Wrong Parameter'
      );
   }

   header('Content-type: application/json');
   echo json_encode($response);
}

function update_karyawan(){
   global $koneksi;

   if(!empty($_GET['id'])){
      $id = $_GET['id'];
   }

   $check = array(
      'nama' => '',
      'jenis_kelamin' => '',
      'alamat' => ''
   );

   $check_match = count(array_intersect_key($_POST, $check));
   if($check_match == count($check)){

      $result = mysqli_query($koneksi, "
         UPDATE karyawan SET
         nama = '$_POST[nama]',
         jenis_kelamin = '$_POST[jenis_kelamin]',
         alamat = '$_POST[alamat]' WHERE id=$id
      ");

      if($result){
         $response = array(
            'status' => 1,
            'message' => 'Update Success'
         );
      }else{
         $response = array(
            'status' => 0,
            'message' => 'Update Failed'
         );
      }
   }else{
      $response = array(
         'status' => 0,
         'message' => 'Wrong Parameter',
         'data' => $id
      );
   }

   header('Content-type: application/json');
   echo json_encode($response);
}

function delete_karyawan(){
   global $koneksi;

   $id = $_GET['id'];
   $query = mysqli_query($koneksi, "DELETE FROM karyawan WHERE id=$id");
   if($query){
      $response = array(
         'status' => 1,
         'message' => 'Delete Success'
      );
   }else{
      $response = array(
         'status' => 0,
         'message' => 'Delete Failed'
      );
   }

   header('Content-type: application/json');
   echo json_encode($response);
}
?>