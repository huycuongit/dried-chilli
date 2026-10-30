<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function __construct(protected Project $model) {}

    public function all() { return $this->model->all(); }
    public function find($id) { return $this->model->findOrFail($id); }

    public function create(array $data)
    {
        $data = $this->payload($data);
        $avatar = $data['avatar'] ?? null;
        unset($data['avatar']);
        $project = $this->model->create($data);
        if ($avatar) $project->uploadImage($project, null, $avatar, 'avatar');
        return $project;
    }

    public function update($id, array $data)
    {
        $project = $this->find($id);
        $data = $this->payload($data);
        $avatar = $data['avatar'] ?? null;
        unset($data['avatar']);
        $project->update($data);
        if ($avatar) $project->uploadImage($project, null, $avatar, 'avatar');
        return $project;
    }

    private function payload(array $data): array
    {
        $payload = array_intersect_key($data, array_flip([
            'title', 'description', 'content', 'avatar',
        ]));
        return $payload;
    }
    public function delete($id)
    {
        $project = $this->find($id);
        if ($project->avatar && Storage::disk('public')->exists($project->avatar)) {
            Storage::disk('public')->delete($project->avatar);
        }
        return $project->delete();
    }

    public function datatables(array $params)
    {
        return $this->model->query()
            ->when($params['keyword'] ?? null, fn($query, $keyword) => $query->where(function ($subQuery) use ($keyword) {
                $subQuery->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            }))
            ->when(isset($params['active']) && $params['active'] !== '', fn($q) => $q->where('active', $params['active']))
            ->orderBy('position')->orderByDesc('id');
    }

    public function filterFrontEnd(array $filters = [])
    {
        return $this->model->query()->active()
            ->when($filters['featured'] ?? null, fn($q) => $q->where('featured', true))
            ->orderBy('position')->orderByDesc('id')->get();
    }
}
