<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Producto | Workshop 5</title><style>body{font-family:Arial,sans-serif;max-width:550px;margin:40px auto;padding:0 15px}label{display:block;margin-top:14px}input,textarea{display:block;width:100%;box-sizing:border-box;padding:10px;margin-top:5px}button,a{display:inline-block;margin-top:18px;padding:10px 14px;background:#175cd3;color:white;border:0;border-radius:5px;text-decoration:none}.error{color:#b42318}</style></head><body>
<h1><?= $producto ? 'Editar producto' : 'Nuevo producto' ?></h1>
<?php foreach($errores as $error): ?><p class="error"><?= esc($error) ?></p><?php endforeach ?>
<form method="post" action="<?= site_url($producto ? 'productos/actualizar/'.$producto['id'] : 'productos/guardar') ?>">
<?= csrf_field() ?>
<label>Nombre<input name="nombre" required maxlength="120" value="<?= esc(old('nombre',$producto['nombre']??''),'attr') ?>"></label>
<label>Descripción<textarea name="descripcion"><?= esc(old('descripcion',$producto['descripcion']??'')) ?></textarea></label>
<label>Precio<input name="precio" type="number" min="0" step="0.01" required value="<?= esc(old('precio',$producto['precio']??''),'attr') ?>"></label>
<label>Cantidad<input name="cantidad" type="number" min="0" step="1" required value="<?= esc(old('cantidad',$producto['cantidad']??''),'attr') ?>"></label>
<button type="submit">Guardar</button> <a href="<?= site_url('productos') ?>">Volver</a>
</form></body></html>
