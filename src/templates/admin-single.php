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
		<form id="singleForm">
		<?php foreach($entry['fields'] as $key => $value): ?>
			<label><?= $key ?></label>
			<?= $contentModel['fields'][$key]['ui']($value); ?>
		<?php endforeach; ?>
			<button>Save</button>
		</form>
	</div>
</main>

<?php
include __DIR__ . '/components/footer.php';