<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UserService
{
    /**
     * @var array
     */
    protected $filesForRemove = [];

    public function create(Request $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = bcrypt($request->input('password'));

        if ( $user->save() ) {
            $image = $this->getImageForUser($request, $user);
            if (!empty($image)) $user->save();

            $this->removeFiles($this->filesForRemove);
            return $user;
        }
        return null;
    }

    protected function getImageForUser(Request $request, $user)
    {
        try {
            $image = $request->file('image');
            if(!empty($image) && $image instanceof UploadedFile ) {
                $fileExtension = $image->getClientOriginalExtension();
                $path = 'users/'.$user->id.'/'.sha1($image->getFilename()).'.'.$fileExtension;

                $imageFinally = \Image::make($image)->resize(200, 200);
                $imageFinally->encode('jpg');

                if ( \Storage::put($path, $imageFinally) ) {
                    $this->filesForRemove[] = $user->image;
                    return $path;
                }
            }
        }catch (\Exception $e){}
        return $user->image;
    }

    protected function removeFiles($files)
    {
        foreach ($files as $file) {
            @\Storage::delete($file);
        }
    }
}
