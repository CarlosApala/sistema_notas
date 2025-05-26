@csrf	
<div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" class="form-control" placeholder="Nombre..." value="{{ old('nombre', $carrera->nombre) }}">
</div>
<div class="form-group">
    <label for="clave">Clave</label>
    <input type="text" name="clave" class="form-control" placeholder="Clave..." value="{{ old('clave', $carrera->clave) }}">
</div>
<div class="form-group">
    <label for="descripcion">Descripcion</label>
    <input type="text" name="descripcion" class="form-control" placeholder="Descripcion..." value="{{ old('descripcion', $carrera->descripcion) }}">
</div>
<div class="form-group">
    <label for="imagen">Imagen</label>
    <input type="file" name="imagen" class="form-control" placeholder="imagen..." value="{{ old('imagen', $carrera->imagen) }}">
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <input class="btn btn-success"type="button" onclick="history.back()" name="Regresar" value="Regresar">
</div>