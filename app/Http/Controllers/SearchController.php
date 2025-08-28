<?php

namespace App\Http\Controllers;

use App\Models\LatestUpdate;
use App\Models\NoticeBoard;
use App\Models\TableContent;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  public function search(Request $request)
  {
    try {
      // Get the search query and pagination settings
      $query = $request->input('query', '');
      $perPage = $request->input('per_page', 10);
      $page = $request->input('page', 1);

      // Initialize the result structure for each model
      $searchResults = [
        'latest_update' => [],
        'table_content' => [],
        'notice_boards' => [],
      ];

      if (!empty($query)) {

        // Search TableContent model (fixed column name to 'title')
        $searchResults['table_content'] = TableContent::where('title', 'like', "%{$query}%")
          // Assuming 'description' is a valid column
          ->paginate($perPage, ['*'], 'page', $page);

        // Search NoticeBoard model (adjusted 'downloads' field to 'description')
        $searchResults['notice_boards'] = NoticeBoard::where('title', 'like', "%{$query}%")
          // Assuming 'description' is a valid column
          ->paginate($perPage, ['*'], 'page', $page);
      }

      // Return the paginated results as JSON
      return response()->json([
        'status' => 'success',
        'data' => $searchResults,
        'message' => 'Search results fetched successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'failure',
        'message' => 'Error occurred while searching: ' . $e->getMessage(),
      ], 500);
    }
  }
}
