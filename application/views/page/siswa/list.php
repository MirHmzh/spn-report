<script src="<?= base_url('') ?>assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="<?= base_url('') ?>assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/jszip/dist/jszip.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url('') ?>assets/vendors/pdfmake/build/vfs_fonts.js"></script>
<div class="x_panel">
  <div class="x_title">
    <h2>Data Siswa</h2>
    <ul class="nav navbar-right panel_toolbox">
      <li>
        <a href="<?= base_url('siswa/save') ?>" title="">
          <button type="button" class="btn btn-primary">
            <i class="fa fa-plus"></i>
          </button>
        </a>
      </li>
      <li>
        <a href="<?= base_url('siswa/export') ?>" title="">
          <button type="button" class="btn btn-success">
            <i class="fa fa-print"></i>
          </button>
        </a>
      </li>
      <li>
        <a href="#" title="">
          <button type="button" class="btn btn-warning btn-import">
            <i class="fa fa-arrow-up"></i>
          </button>
        </a>
      </li>
    </ul>
    <div class="clearfix"></div>
  </div>
  <div class="x_content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card-box table-responsive">
          <table id="datatable-siswa" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Foto</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Nosis Panjang</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td>1</td>
                <td>3515</td>
                <td>John Doe</td>
                <td>cakjack@mail.co</td>
                <td>23</td>
                <td>80.90</td>
                <td>
                  <button type="button" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                  </button>
                  <button type="button" class="btn btn-warning">
                    <i class="fa fa-pencil"></i>
                  </button>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalImport">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Import Siswa XLSX</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <form class="form-import" action="" method="POST" role="form" enctype="multipart/form-data">
            <div class="form-group">
              <label for="">Pilih Spreadsheet (xlsx)</label>
              <input type="file" name="file" class="form-control" id="" placeholder="">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-start-import">Import</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $('#datatable-siswa').DataTable({
      processing: true,
      serverSide : true,
      ordering: true,
      deferRender: true,
      ajax : {
        url : '<?= base_url() ?>index.php/Siswa/get_siswa',
        method : "POST"
      },
      columns : [
        { data : "foto",
          render : (data, type, row) => {
            let html = `<img style="max-width: 100px; min-width: 100px; max-height: 120px; min-height: 120px;" src="<?= base_url() ?>assets/uploads/${data}">`;
            return html;
          }
        },
        { data : "nik_siswa" ,
          render : (data, type, row) => {
            let html = `<a href="<?= base_url() ?>index.php/Siswa/save/${row.id_siswa}">${data}</a>`;
            return html;
          },
        },
        { data : "nama_siswa" },
        { data : "nosis_panjang" },
        { data : "id_siswa",
          render : (data, type, row) => {
          let html = `
            <a href="<?= base_url('siswa/delete/') ?>${data}" title="">
              <button type="button" class="btn btn-danger" data-id="${data}">
                <i class="fa fa-trash"></i>
              </button>
            </a>
            <a href="<?= base_url('siswa/save/') ?>${data}" title="">
              <button type="button" class="btn btn-warning" data-id="${data}">
                <i class="fa fa-pencil"></i>
              </button>
            </a>`
            return html;
          }
        }
      ],
    });
  });
  $('.btn-import').click((e) => {
    e.preventDefault();
    $('#modalImport').modal('toggle');
  });
  $('.btn-start-import').click(() => {
    let fd = new FormData();
    let files = $('input[name="file"]')[0].files;
    fd.append('file', files[0]);
    $.ajax({
      url: "<?= base_url('siswa/import') ?>",
      type: 'POST',
      data: fd,
      dataType: 'json',
      contentType: false,
      processData: false,
      success: (data) => {
        Swal.fire('Selesai',data.msg,data.type)
      },
      error : () => {
        Swal.fire('Gagal','Cek kembali format spreadsheet Anda','warning')
      }
    }).fail(() => {
      Swal.fire('Gagal','Cek kembali format spreadsheet Anda','warning')
    });

  });
</script>
