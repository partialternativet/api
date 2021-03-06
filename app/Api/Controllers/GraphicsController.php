<?php

namespace Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GraphicsController extends BaseController
{
    /**
     * Norwegian map with municipalities where Alternativet is represented highlighted
     */
    public function membersMapNorway()
    {
        $data = "";
        if ( ! Storage::exists('members-norway-map.svg') || Storage::lastModified('members-norway-map.svg') <= time() - 60 * 60 * 24 )
        {
            $svg = simplexml_load_file(base_path() . '/resources/svg/Norway_municipalities_2012_blank.svg');

            // Determine which municipalities there are members in
            $result = DB::select( DB::raw("
              select postal_areas.municipality_code, count(*) as count
              from users
              left join postal_areas
              on (users.postal_code = postal_areas.postal_code)
              group by municipality_code"));

            $municipalities = [];
            foreach ($result as $row)
            {
                if ( $row->municipality_code )
                {
                    $municipalities[] = $row->municipality_code;
                }
            }

            foreach ( $svg->g as $county )
            {
                foreach ($county->path as $path)
                {
                    if ( in_array( $path['id'], $municipalities ) )
                    {
                        // There are members in this municipality
                        $path['style'] = 'fill:#0f0;fill-opacity:1;stroke:none';
                    }
                    else
                    {
                        $path['style'] = 'fill:#555;fill-opacity:1;stroke:none';
                    }
                }
            }

            $data = $svg->asXML();
            Storage::put('members-norway-map.svg', $data);
        }
        
        if ( empty($data) )
        {
            $data = Storage::get('members-norway-map.svg');
        }

        return response($data)
            ->header('Content-Type', 'image/svg+xml');
    }
}
