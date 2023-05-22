<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $page = intval($request->get('page'));
        $perPage = intval($request->get('per_page'));
        $totalRecords = DB::select('SELECT COUNT(*) as total_records from books')[0]->total_records;
        $filters = json_decode($request->get('filters'), true);


        $offset = $page === 1 ? 0 : ($page - 1) * $perPage;

        $defaultColumns = [
            'books.id',
            'books.name',
            'GROUP_CONCAT(genres.name) as genres',
            'books.publish_date',
            'authors.first_name',
            'authors.last_name',
            'authors.birthday',
            'authors.year_of_death',
            'books.avg_reading_time',
        ];

        $filteredColumns = implode($defaultColumns, ',');

        $query = "
            SELECT $filteredColumns from books
            LEFT JOIN book_genre ON books.id = book_genre.book_id
            LEFT JOIN genres ON genres.id = book_genre.genre_id
            LEFT JOIN authors ON books.author_id = authors.id
            ";

        if ($filters) {
           $query .= $this->addFiltersToQuery($filters);
        }

        $query .= "GROUP BY books.id ORDER BY books.id LIMIT $perPage OFFSET $offset ";


        $books = DB::select($query);

        return response()->json([
            'data' => $books,
            'page' => $page,
            'per_page' => $perPage,
            'total_records' => $totalRecords,
        ]);
    }


    //ToDo Add Validation Request Class
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {

        DB::beginTransaction();
        try {
            $genres = $request->get('genres');
            $fillableFields = (new Book())->getFillable();
            $values = [];
            $fields = implode($fillableFields, ',');

            foreach ($fillableFields as $field) {
                $values[] = "'" . $request->get($field) . "'";
            }
            $values = implode($values, ', ');

            DB::insert("
            INSERT INTO `books` ($fields)
            VALUES ($values)
            ");

            $bookId = DB::select("SELECT books.id from books ORDER BY id DESC LIMIT 1")[0]->id;

            foreach ($genres as $genre) {
                DB::insert("
                INSERT INTO `book_genre` (book_id, genre_id)
                VALUES ($bookId, $genre)
                ");
            }

            DB::commit();
        } catch (\Exception $exception) {
            dd($exception->getMessage(), $exception->getLine());
            DB::rollBack();
        }

        return response()->json([
            'message' => "Successfully Created",
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $query = "DELETE FROM `books` WHERE id = $id";

        $result = DB::delete($query);

        return response()->json([
            'success' => true,
            'message' => "Deleted Successfully",
        ]);
    }

    private function addFiltersToQuery($filters)
    {
        $value = $filters['value'];
        $field = $filters['field'];
        $query = '';

        if ($filters['type'] === 'array') {
            $value = implode($filters['value'], ',');
            $query .= " WHERE genres.$field IN ($value)";
        } elseif ($filters['type'] === 'text') {
            $value = strtoupper($value);
            $query .= " WHERE UPPER(authors.$field) LIKE '%$value%'";
        } elseif ($filters['type'] === 'bool') {
            $query .= " WHERE authors.year_of_death <= now()";
        } else {
            $field = $field === 'publish_date' ? 'books.' . $field : "authors." . $field;
            $query .= " WHERE $field = '$value'";
        }

        return $query;
    }
}
