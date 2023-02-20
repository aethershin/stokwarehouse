
    <?php if($this->session->flashdata('msg')=='success-import'):?>
            <script type="text/javascript">
                    Toastify({
                        text: "Data berhasil di Import",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    }).showToast()
            </script>
    <?php elseif($this->session->flashdata('msg')=='falied-import-mysql'):?>
            <script type="text/javascript">
                    Toastify({
                        text: "Gagal Import",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #ff4343, #ff8a8a)",
                    }).showToast()
            </script>
    <?php elseif($this->session->flashdata('msg')=='falied-import-ekstensi'):?>
            <script type="text/javascript">
                    Toastify({
                        text: "Format Harus .xls , xlsx",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #ff4343, #ff8a8a)",
                    }).showToast()
            </script>           
    <?php else:?>
    <?php elseif($this->session->flashdata('msg')=='falied-change-image'):?>
            <script type="text/javascript">
                    Toastify({
                        text: "Format Harus .jpg , png , .jpeg , .webp",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #ff4343, #ff8a8a)",
                    }).showToast()
            </script>           
    <?php else:?>
    <?php endif;?>