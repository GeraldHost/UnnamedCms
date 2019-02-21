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
		<p><b>Admin</b></p>
		<p>Entries: <?= $model; ?></p>
		<ul>
			<?php foreach($entries as $entry): ?>
				<a href="<?= $entry['model']?>/<?= $entry['id']; ?>"><li><?= $entry['uid']?></li></a>
			<?php endforeach; ?>
		</ul>
	</div>
</main>

<?php
include __DIR__ . '/components/footer.php';