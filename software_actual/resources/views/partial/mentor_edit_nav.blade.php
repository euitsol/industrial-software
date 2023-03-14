<div class="row mb-4" id="edit-mentor">
    <div class="col">
        <div class="border p-1 text-center">
            <a href="{{route('mentor.personal-info.edit', $mentor->id)}}" class="nav-link">Personal</a>
        </div>
    </div>
    <div class="col">
        <div class="border p-1 text-center">
            <a href="{{route('mentor.career-objective.edit', $mentor->id)}}" class="nav-link">Objective</a>
        </div>
    </div>
    <div class="col">
        <div class="border p-1 text-center">
            <a href="{{route('mentor.employment-history.edit', $mentor->id)}}" class="nav-link">Employment</a>
        </div>
    </div>
    <div class="col">
        <div class="border p-1 text-center">
            <a href="{{route('mentor.academic-qualification.edit', $mentor->id)}}" class="nav-link">Education</a>
        </div>
    </div>
    <div class="col">
        <div class="border p-1 text-center">
            <a href="{{route('mentor.specialization.edit', $mentor->id)}}" class="nav-link">Specialization</a>
        </div>
    </div>
</div>