<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->
<!------ Include the above in your HEAD tag ---------->

<!--
We will create a family tree using just CSS(3)
The markup will be simple nested lists
-->
<style>
    /*Now the CSS*/
/* * {margin: 0; padding: 0;} */

*, :after, :before {
    outline: 0 !important;
}

#struktur::after {
    padding-top: 56.25%;
    display: block;
}

.struktur-wrapper{
    overflow-x: scroll;
    /* position: absolute; */
    /* top: 0; bottom: 0; right: 0; left: 0; */
    /* left: 0; */
    /* right: 0; */
    /* transform: scale(0.6); */
    /* width: 3000px; */
    /* position: absolute */
    /* width: auto; */
    /* display: inline-block; */
}

.tree ul {
    padding-top: 20px; position: relative;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

.tree li {
	float: left; text-align: center;
	list-style-type: none;
	position: relative;
	padding: 20px 5px 0 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
	content: '';
	position: absolute; top: 0; right: 50%;
	border-top: 1px solid #ccc;
	width: 50%; height: 20px;
    outline: 0 !important;
}
.tree li::after{
	right: auto; left: 50%;
	border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
	display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
	border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
	border-right: 1px solid #ccc;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
	content: '';
	position: absolute; top: 0; left: 50%;
	border-left: 1px solid #ccc;
	width: 0; height: 20px;
    outline: 0 !important;
}

.tree li a{
	border: 1px solid #ccc;
	padding: 5px 10px;
	text-decoration: none;
	color: #666;
	font-family: arial, verdana, tahoma;
	font-size: 11px;
	display: inline-block;
	
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li a:hover, .tree li a:hover+ul li a {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree li a:hover+ul li::after, 
.tree li a:hover+ul li::before, 
.tree li a:hover+ul::before, 
.tree li a:hover+ul ul::before{
	border-color:  #94a0b4;
}

.bidang{
    max-width: 175px !important;
}

.sub_bidang{
    max-width: 150px;
}

/* level_1 */
.td_nama_jabatan_level_1{
    font-size: .85rem;
    font-weight: bold;
    text-transform: uppercase;
    border-bottom: 1px solid #ccc;
}

.span_nama_pejabat_level_1{
    font-size: 1.3rem;
    font-weight: bold;
    text-align: left;
}

.span_nip_pejabat_level_1, .span_pangkat_pejabat_level_1{
    font-size: .9rem;
    font-weight: bold;
    text-align: left;
}

/* level_2 */
.td_nama_jabatan_level_2{
    font-size: .75rem;
    font-weight: bold;
    text-transform: uppercase;
    border-bottom: 1px solid #ccc;
    height: 100px;
}

.span_nama_pejabat_level_2{
    font-size: .8rem;
    font-weight: bold;
    text-align: center;
}

.span_nip_pejabat_level_2, .span_pangkat_pejabat_level_2{
    font-size: .75rem;
    font-weight: normal;
    text-align: center;
}

/* level_3 */
.td_nama_jabatan_level_3{
    font-size: .75rem;
    font-weight: bold;
    text-transform: uppercase;
    border-bottom: 1px solid grey;
    height: 100px;
}

.span_nama_pejabat_level_3{
    font-size: .8rem;
    font-weight: bold;
    text-align: center;
}

.span_nip_pejabat_level_3, .span_pangkat_pejabat_level_3{
    font-size: .75rem;
    font-weight: normal;
    text-align: center;
}

/*Thats all. I hope you enjoyed it.
Thanks :)*/
</style>
<!-- <center> -->
<div class="struktur-wrapper tree">
    <ul>
        <li>
            <a>
                <table>
                    <tr>
                        <td class="td_nama_jabatan_level_1">
                            <?=$result['kepalaskpd']['nama_jabatan']?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row mt-2">
                                <div class="col-lg-3 col-md-3 col-sm-3 text-center"
                                style="vertical-align: middle;">
                                    <img style="width: 75px; height: 75px; object-fit: cover; top: 50%;" class="img-fluid rounded-circle mb-2 b-lazy"
                                    src="<?php
                                        $path = './assets/fotopeg/'.$result['kepalaskpd']['pegawai']['fotopeg'];
                                        // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                        if($result['kepalaskpd']['pegawai']['fotopeg']){
                                        if (file_exists($path)) {
                                        $src = './assets/fotopeg/'.$result['kepalaskpd']['pegawai']['fotopeg'];
                                        //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                        } else {
                                        $src = './assets/img/user.png';
                                        // $src = '../siladen/assets/img/user.png';
                                        }
                                        } else {
                                        $src = './assets/img/user.png';
                                        }
                                        echo base_url().$src;?>" /> 
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 text-left">
                                    <span class="span_nama_pejabat_level_1"><?=$result['kepalaskpd']['pegawai'] ? getNamaPegawaiFull($result['kepalaskpd']['pegawai']) : '(KOSONG)'?></span><br>
                                    <span class="span_nip_pejabat_level_1"><?=$result['kepalaskpd']['pegawai'] ? $result['kepalaskpd']['pegawai']['nipbaru'] : ''?></span><br>
                                    <span class="span_pangkat_pejabat_level_1"><?=$result['kepalaskpd']['pegawai'] ? $result['kepalaskpd']['pegawai']['nm_pangkat'] : ''?></span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </a>
            <ul>
                <?php if($result['bidang']){ foreach($result['bidang'] as $b){ if($b['nama_bidang'] != 'Belum Setting Bidang / Bagian'){ ?>
                    <li>
                        <a class="bidang">
                            <table>
                                <tr>
                                    <td class="td_nama_jabatan_level_2">
                                        <?=$b['nama_jabatan_kepala']?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row mt-2">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <center>
                                                    <img style="width: 75px; height: 75px;object-fit: cover" class="img-fluid rounded-circle mb-2 b-lazy"
                                                    src="<?php
                                                        $path = './assets/fotopeg/'.$b['kepala']['fotopeg'];
                                                        // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                                        if($b['kepala']['fotopeg']){
                                                        if (file_exists($path)) {
                                                        $src = './assets/fotopeg/'.$b['kepala']['fotopeg'];
                                                        //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                                        } else {
                                                        $src = './assets/img/user.png';
                                                        // $src = '../siladen/assets/img/user.png';
                                                        }
                                                        } else {
                                                        $src = './assets/img/user.png';
                                                        }
                                                        echo base_url().$src;?>" /> 
                                                </center>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <span class="span_nama_pejabat_level_2"><?=$b['kepala'] ? getNamaPegawaiFull($b['kepala']) : '(KOSONG)'?></span><br>
                                                <span class="span_nip_pejabat_level_2"><?=$b['kepala'] ? $b['kepala']['nipbaru'] : ''?></span><br>
                                                <span class="span_pangkat_pejabat_level_2"><?=$b['kepala'] ? $b['kepala']['nm_pangkat'] : ''?></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </a>
                        <?php if($b['hide_sub_bidang'] == false){ ?>
                        <ul>
                            <?php if(isset($b['sub_bidang'])){ foreach($b['sub_bidang'] as $sb){ if($sb['list_pegawai'] && count($sb['list_pegawai']) > 0){ ?>
                                <li>
                                    <a class="sub_bidang">
                                        <table>
                                            <tr>
                                                <td class="td_nama_jabatan_level_3">
                                                    <?=$sb['nama_jabatan_kepala']?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="row mt-2">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <center>
                                                                <img style="width: 75px; height: 75px;object-fit: cover" class="img-fluid rounded-circle mb-2 b-lazy"
                                                                src="<?php
                                                                    $path = './assets/fotopeg/'.$sb['kepala']['fotopeg'];
                                                                    // $path = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                                                    if($sb['kepala']['fotopeg']){
                                                                    if (file_exists($path)) {
                                                                    $src = './assets/fotopeg/'.$sb['kepala']['fotopeg'];
                                                                    //  $src = '../siladen/assets/fotopeg/'.$profil_pegawai['fotopeg'];
                                                                    } else {
                                                                    $src = './assets/img/user.png';
                                                                    // $src = '../siladen/assets/img/user.png';
                                                                    }
                                                                    } else {
                                                                    $src = './assets/img/user.png';
                                                                    }
                                                                    echo base_url().$src;?>" /> 
                                                            </center>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                            <span class="span_nama_pejabat_level_3"><?=$sb['kepala'] ? getNamaPegawaiFull($sb['kepala']) : '(KOSONG)'?></span><br>
                                                            <span class="span_nip_pejabat_level_3"><?=$sb['kepala'] ? $sb['kepala']['nipbaru'] : ''?></span><br>
                                                            <span class="span_pangkat_pejabat_level_3"><?=$sb['kepala'] ? $sb['kepala']['nm_pangkat'] : ''?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </a>
                                </li>
                            <?php } } } ?>
                        </ul>
                        <?php } ?>
                    </li>
                <?php } } } ?>
            </ul>
        </li>
    </ul>
</div>
<!-- </center> -->