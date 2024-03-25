<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH POST</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">NIM</label>
                    <input type="text" class="form-control" id="nim">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nim"></div>
                </div>
                

                <div class="form-group">
                    <label class="control-label">Nama</label>
                    <textarea class="form-control" id="nama" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Alamat</label>
                    <textarea class="form-control" id="alamat" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Hobi</label>
                    <textarea class="form-control" id="hobi" rows="4"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-hobi"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-create-post', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let nim   = $('#nim').val();
        let nama = $('#nama').val();
        let alamat = $('#alamat').val();
        let hobi = $('#hobi').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/posts`,
            type: "POST",
            cache: false,
            data: {
                "nim": nim,
                "nama": nama,
                "alamat": alamat,
                "hobi": hobi,
                "_token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                //data post
                let post = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.nim}</td>
                        <td>${response.data.nama}</td>
                        <td>${response.data.alamat}</td>
                        <td>${response.data.hobi}</td>
                    </tr>
                `;
                
                //append to table
                $('#table-posts').prepend(post);
                
                //clear form
                $('#nim').val('');
                $('#nama').val('');
                $('#alamat').val('');
                $('#hobi').val('');

                //close modal
                $('#modal-create').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.title[0]) {

                    //show alert
                    $('#alert-nim').removeClass('d-none');
                    $('#alert-nim').addClass('d-block');

                    //add message to alert
                    $('#alert-nim').html(error.responseJSON.title[0]);
                } 

                if(error.responseJSON.content[0]) {

                    //show alert
                    $('#alert-nama').removeClass('d-none');
                    $('#alert-nama').addClass('d-block');

                    //add message to alert
                    $('#alert-nama').html(error.responseJSON.content[0]);
                } 

                if(error.responseJSON.title[0]) {

                    //show alert
                    $('#alert-alamat').removeClass('d-none');
                    $('#alert-alamat').addClass('d-block');

                    //add message to alert
                    $('#alert-alamat').html(error.responseJSON.title[0]);
                } 

                if(error.responseJSON.title[0]) {

                    //show alert
                    $('#alert-hobi').removeClass('d-none');
                    $('#alert-hobi').addClass('d-block');

                    //add message to alert
                    $('#alert-hobi').html(error.responseJSON.title[0]);
                } 

            }

        });

    });

</script>