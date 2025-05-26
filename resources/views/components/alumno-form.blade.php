@props(['alumno', 'materias', 'carreras'])
@csrf
<div class="form-group">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" class="form-control" placeholder="Nombre..." value="{{ old('nombre', $alumno->nombre) }}">
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" placeholder="Email..." value="{{ old('email', $alumno->email) }}">
</div>
<div class="form-group">
    <label for="matricula">Matricula</label>
    <input type="text" name="matricula" class="form-control" placeholder="Matricula..." value="{{ old('matricula', $alumno->matricula) }}">
</div>
<div class="form-group">
    <label for="direccion">Direccion</label>
    <input type="text" name="direccion" class="form-control" placeholder="Direccion..." value="{{ old('direccion', $alumno->direccion) }}">
</div>
<div class="form-group">
    <label for="telefono">Telefono</label>
    <input type="text" name="telefono" class="form-control" placeholder="Telefono..." value="{{ old('telefono', $alumno->telefono) }}">
</div>
<div class="form-group">
    <label for="semestre">Semestre</label>
    <input type="text" name="semestre" class="form-control" placeholder="Semestre..." value="{{ old('semestre', $alumno->semestre) }}">
</div>
<div class="form-group">
    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
    <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Fecha de Nacimiento..." value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento) }}">
</div>

<div class="form-group">
    <label for="sexo">Sexo</label>
    <select name="sexo" class="form-control">
        <option value="">Seleccione sexo</option>
        <option value="Hombre" {{ $alumno->sexo == 'Hombre' ? 'selected' : '' }}>Hombre</option>
        <option value="Mujer" {{ $alumno->sexo == 'Mujer' ? 'selected' : '' }}>Mujer</option>
    </select>
</div>

<div class="form-group">
    <label for="edad">Edad</label>
    <input type="text" name="edad" class="form-control" placeholder="Edad..." value="{{ old('edad', $alumno->edad) }}">
</div>

<div class="form-group">
    <label for="curp">CURP</label>
    <input type="text" name="curp" class="form-control" placeholder="CURP..." value="{{ old('curp', $alumno->curp) }}">
</div>

<div class="form-group">
    <label for="fecha_ingreso">Fecha de Ingreso</label>
    <input type="date" name="fecha_ingreso" class="form-control" placeholder="Fecha de Ingreso..." value="{{ old('fecha_ingreso', $alumno->fecha_ingreso) }}">
</div>

<div class="form-group">
    <label for="estatus">Estatus</label>
    <select name="estatus" class="form-control">
        <option value="">Seleccione estatus</option>
        <option value="Activo" {{ $alumno->estatus == 'Activo' ? 'selected' : '' }}>Activo</option>
        <option value="Inactivo" {{ $alumno->estatus == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
    </select>
</div>

<div class="form-group">
    <label for="observaciones">Observaciones</label>
    <textarea name="observaciones" class="form-control" placeholder="Observaciones...">{{ old('observaciones', $alumno->observaciones) }}</textarea>
</div>





<div class="form-group">
    <label for="materia_id">Materia</label>
    <select name="materia_id" class="form-control">
        <option value="">Seleccione una materia</option>
        @foreach($materias as $materia)
            <option value="{{ $materia->id }}" {{ $materia->id == $alumno->materia_id ? 'selected' : '' }}>
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
            <option value="{{ $carrera->id }}" {{ $carrera->id == $alumno->carrera_id ? 'selected' : '' }}>
                {{ $carrera->nombre }}
            </option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <input class="btn btn-success" type="button" onclick="history.back()" name="Regresar" value="Regresar">
</div>