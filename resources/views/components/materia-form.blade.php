@props(['profesores', 'materias', 'carreras'])
@csrf	
<div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" class="form-control" placeholder="Nombre de la Materia..." value="{{ old('nombre', $materias->nombre) }}">
</div>
<div class="form-group">
    <label for="codigo">Codigo</label>
    <input type="text" name="codigo" class="form-control" placeholder="Codigo..." value="{{ old('codigo', $materias->codigo) }}">
</div>
<div class="form-group">
    <label for="creditos">Creditos</label>
    <input type="number" name="creditos" class="form-control" placeholder="Creditos..." value="{{ old('creditos', $materias->creditos) }}">
</div>
<div class="form-group">
    <label for="descripcion">Descripcion</label>
    <input type="text" name="descripcion" class="form-control" placeholder="Descripcion..." value="{{ old('descripcion', $materias->descripcion) }}">
</div>

<div class="form-group">
    <label for="profesor_id">Profesor</label>
    <select name="profesor_id" class="form-control">
        <option value="">Seleccione un profesor</option>
        @foreach($profesores as $profesor)
            <option value="{{ $profesor->id }}" {{ $profesor->id == $materias->profesor_id ? 'selected' : '' }}>
                {{ $profesor->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="carrera_id">Carrera</label>
    <select name="carrera_id" class="form-control">
        <option value="">Seleccione una carrera</option>
        @foreach($carreras as $carrera)
            <option value="{{ $carrera->id }}" {{ $carrera->id == $materias->carrera_id ? 'selected' : '' }}>
                {{ $carrera->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <input class="btn btn-success"type="button" onclick="history.back()" name="Regresar" value="Regresar">
</div>