<?php
include __DIR__ . '/components/header.php';
?>

<header>
	<div class="container">
		<div id="logo">CMS</div>
		<h1 class="title">Admin</h1>
	</div>
</header>

<main>
	<div class="container">
		<div class="list">
			<?php foreach($entries as $entry) : ?>
				<a href="<?= '/cms/admin/' . $entry['model'] . '/' . $entry['id']; ?>">
					<div class="item">
						<?php echo 'ID:' . $entry['id'] . ' ' . $entry['uid']; ?>
						<span class="label">
							<?= $entry['model']; ?>
						</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</main>

<?php
include __DIR__ . '/components/footer.php';