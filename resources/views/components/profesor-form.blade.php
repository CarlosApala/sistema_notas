@props(['profesor', 'materias', 'carreras'])
@csrf
<div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" class="form-control" placeholder="Nombre..." value="{{ old('nombre', $profesor->nombre) }}">
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" placeholder="Email..." value="{{ old('email', $profesor->email) }}">
</div>
<div class="form-group">
    <label for="telefono">Telefono</label>
    <input type="number" name="telefono" class="form-control" placeholder="Telefono..." value="{{ old('telefono', $profesor->telefono) }}">
</div>
<div class="form-group">
    <label for="direccion">Direccion</label>
    <input type="text" name="direccion" class="form-control" placeholder="Direccion..." value="{{ old('imagen', $profesor->direccion) }}">
</div>
<div class="form-group">
    <label for="cedula">Cedula</label>
    <input type="number" name="cedula" class="form-control" placeholder="Cedula..." value="{{ old('imagen', $profesor->cedula) }}">
</div>
<div class="form-group">
    <label for="experiencia">Experiencia</label>
    <input type="number" name="experiencia" class="form-control" placeholder="Experiencia..." value="{{ old('experiencia', $profesor->experiencia) }}">
</div>
<div class="form-group">
    <label for="fecha_contratacion">Fecha de Contratacion</label>
    <input type="date" name="fecha_contratacion" class="form-control" placeholder="Fecha de Contratacion..." value="{{ old('imagen', $profesor->fecha_contratacion) }}">
</div>
<div class="form-group">
    <label for="materia_id">Materia</label>
    <select name="materia_id" class="form-control">
        <option value="">Seleccione una materia</option>
        @foreach($materias as $materia)
            <option value="{{ $materia->id }}" {{ $materia->id == $profesor->materia_id ? 'selected' : '' }}>
                {{ $materia->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="carrera_id">Carrera</label>
    <select name="carrera_id" class="form-control">
        <option value="">Seleccione una carrera</option>
        @foreach($carreras as $carrera)
            <option value="{{ $carrera->id }}" {{ $carrera->id == $profesor->carrera_id ? 'selected' : '' }}>
                {{ $carrera->nombre }}
            </option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <input class="btn btn-success" type="button" onclick="history.back()" name="Regresar" value="Regresar">
</div>