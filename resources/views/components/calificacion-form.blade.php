@props(['calificacion','profesores', 'materias', 'carreras', 'alumnos'])
@csrf


<div class="form-group">
    <label for="calificacion">Calificacion</label>
    <input type="number" name="calificacion" class="form-control" placeholder="Calificacion..." value="{{ old('calificacion', $calificacion->calificacion) }}">
</div>

<div class="form-group">
    <label for="alumno_id">Alumno</label>
    <select name="alumno_id" class="form-control">
        <option value="">Seleccione un alumno</option>
        @foreach($alumnos as $alumno)
            <option value="{{ $alumno->id }}" {{ $alumno->id == $calificacion->alumno_id ? 'selected' : '' }}>
                {{ $alumno->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="profesor_id">Profesor</label>
    <select name="profesor_id" class="form-control">
        <option value="">Seleccione un profesor</option>
        @foreach($profesores as $profesor)
            <option value="{{ $profesor->id }}" {{ $profesor->id == $calificacion->profesor_id ? 'selected' : '' }}>
                {{ $profesor->nombre }}
            </option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <label for="materia_id">Materia</label>
    <select name="materia_id" class="form-control">
        <option value="">Seleccione una materia</option>
        @foreach($materias as $materia)
            <option value="{{ $materia->id }}" {{ $materia->id == $calificacion->materia_id ? 'selected' : '' }}>
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
            <option value="{{ $carrera->id }}" {{ $carrera->id == $calificacion->carrera_id ? 'selected' : '' }}>
                {{ $carrera->nombre }}
            </option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <button class="btn btn-primary" type="submit">Guardar</button>
    <input class="btn btn-success" type="button" onclick="history.back()" name="Regresar" value="Regresar">
</div>