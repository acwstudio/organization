<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\Faculty;
use App\Repositories\Api\Faculties\FacultyRepository;
use Spatie\QueryBuilder\QueryBuilder;

final class FacultyService
{
    private FacultyRepository $facultyRepository;

    /**
     * @param FacultyRepository $facultyRepository
     */
    public function __construct(FacultyRepository $facultyRepository)
    {
        $this->facultyRepository = $facultyRepository;
    }

    /**
     * @return QueryBuilder
     */
    public function index(): QueryBuilder
    {
        return $this->facultyRepository->index();
    }

    /**
     * @param int $id
     * @return QueryBuilder
     */
    public function show(int $id): QueryBuilder
    {
        $faculty = Faculty::findOrFail($id);

        return $this->facultyRepository->show($faculty);
    }
}
