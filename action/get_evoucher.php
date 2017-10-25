<?php
    /* Database connection start */
    $servername = "localhost";
    $username = "root";
    $password = "ilovejkt48";
    $dbname = "checklist_system_db";

    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

    /* Database connection end */


    // storing  request (ie, get/post) global array to a variable  
    $requestData= $_REQUEST;


    $columns = array( 
    // datatable column index  => database column name
        0   =>'code', 
        1   => 'barcode',
        2   => 'nominal',
        4   => 'voucher_category_id',
        4   => 'active_date',
        5   => 'expire_date',
        6   => 'status',
    );

    // getting total number records without any search
    //$sql = "SELECT voucher.code, voucher.barcode,voucher.nominal,voucher.voucher_category_id,voucher.active_date,voucher.expire_date,voucher.status,voucher_category.id,voucher_category.name categoryName";
    $sql = "SELECT voucher.id,voucher.code, voucher.barcode,voucher.nominal,voucher.voucher_category_id,voucher.active_date,voucher.expire_date,voucher.status";
    $sql.= " FROM voucher";
    $sql.= " WHERE voucher_type='ELEKTRIK'";
   // $sql.= " INNER JOIN voucher_category ON voucher.voucher_category_id=voucher_category.id;";
    //var_dump($sql); die();
    $query=mysqli_query($conn, $sql) or die("action/get_voucher.php: get voucher");
    $totalData = mysqli_num_rows($query);
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


    $sql = "SELECT voucher.id,voucher.code, voucher.barcode,voucher.nominal,voucher.voucher_category_id,voucher.active_date,voucher.expire_date,voucher.status";
    $sql.= " FROM voucher";
    $sql.= " WHERE voucher_type='ELEKTRIK'";
    //$sql.= " INNER JOIN voucher_category ON voucher.voucher_category_id=voucher_category.id;";
   
    if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
        $sql.=" AND ( voucher.barcode LIKE '".$requestData['search']['value']."%' ";    
        $sql.=" OR voucher.nominal LIKE '".$requestData['search']['value']."%' ";
    }
    $query=mysqli_query($conn, $sql) or die("action/get_voucher.php: get voucher");
    $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
    //var_dump($sql); die();
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
    $query=mysqli_query($conn, $sql) or die("action/get_voucher.php: get voucher");

    $data = array();
    while( $row=mysqli_fetch_array($query) ) {  // preparing an array
        $nestedData=array(); 

        $nestedData[] = $row["code"];
        $nestedData[] = $row["barcode"];
        $nestedData[] = $row["nominal"];
        $nestedData[] = $row["active_date"];
        $nestedData[] = $row["expire_date"];
        $nestedData[] = $row["status"];
        $nestedData[] = '<td class="btn-group btn-group-box">
                            <table>
                                <tr>
                                    <td valign="top">
                                        <a href="content.php?module=voucher&act=edit&id='.$row[id].'" style="margin-right:3px;" class="btn btn-sm btn-info">Edit</a>
                                    </td>
                                    <td>
                                        <form method="post" action="action/delete_voucher.php?id="'.$row[id].'" id="itemhapus'.$row[id].'">
                                            <i class="fa fa-trash"></i><input type="submit" class="btn btn-sm btn-danger" value="Delete">
                                        </form>
                                        <script type="text/javascript">
                                            document.querySelector("#itemhapus'.$row[id].'").addEventListener("submit", function(e) {
                                                var form = this;
                                                e.preventDefault();
                                                swal({
                                                    title: "Apa Anda Yakin?",
                                                    type: "warning",
                                                    showCancelButton: true,
                                                    confirmButtonColor: "#DD6B55",
                                                    cancelButtonText: "Batal",
                                                    confirmButtonText: "Yakin",
                                                    closeOnConfirm: false,
                                                    closeOnCancel: false
                                                },
                                                function(isConfirm) {
                                                    if (isConfirm) {
                                                        form.submit();
                                                    }
                                                    else {
                                                        swal("Batal", "", "error");
                                                    }
                                                });
                                            });
                                        </script>
                                    </td>
                                </tr>
                            </table>
                        </td>';

        $data[] = $nestedData;
    }



    $json_data = array(
                "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => intval( $totalData ),  // total number of records
                "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data   // total data array
                );
    
    echo json_encode($json_data);  // send data as json format

?>
