<?php

$success = $this->session->flashdata('success');
$error = $this->session->flashdata('error');
$warning = $this->session->flashdata('warning');
?>
<script src="<?= base_url('assets/js/sweetalert.min.js') ?>"></script>
<?php if ($success) { ?>
	<script>
		swal(
			"Berhasil!",
			"<?php echo addslashes($success) ?>",
			"success"
		)
	</script>
	<?php $this->session->unset_userdata('success'); ?>
<?php } ?>

<?php if ($error) { ?>
	<script>
		swal(
			"Gagal!",
			"<?php echo addslashes($error) ?>",
			"error"
		)
	</script>
	<?php $this->session->unset_userdata('error'); ?>
<?php } ?>

<?php if ($warning) { ?>
	<script>
		swal(
			"Warning!",
			"<?php echo addslashes($warning) ?>",
			"warning"
		)
	</script>
	<?php $this->session->unset_userdata('warning'); ?>
<?php } ?>