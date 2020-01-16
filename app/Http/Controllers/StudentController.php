<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Resources\Student as StudentResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Return request with valid data
     *
     * @return array
     */
    private function validateData($student = NULL)
    {
        return request()->validate([
            'surname' => 'required',
            'first_name' => 'required',
            'email' => 'bail|required|email:rfc,dns|unique:students,email'.(isset($student) ? ','.$student->id : ''),
            'student_number' => 'bail|required|unique:students,student_number'.(isset($student) ? ','.$student->id : ''),
            'group_id' => 'nullable|bail|numeric|exists:groups,id',
        ]);
    }

    /**
     * Return request with valid data on update
     *
     * @return array
     */
    private function validateDataUpdate($student = NULL)
    {
        return request()->validate([
            'email' => 'bail|email:rfc,dns|unique:students,email'.(isset($student) ? ','.$student->id : ''),
            'student_number' => 'bail|unique:students,student_number'.(isset($student) ? ','.$student->id : ''),
            'group_id' => 'nullable|bail|numeric|exists:groups,id',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Student::class);
        
        return StudentResource::collection(Student::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Student::class);

        $student = Student::create($this->validateData());

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $this->authorize('view', $student);
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $this->authorize('update', $student);

        $student->update($this->validateDataUpdate($student));
        
        return (new StudentResource($student))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $this->authorize('delete', $student);
        $student->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    public function import(Request $request) {
        if(!$request->has('importfile') && !$request->file('importfile')) {
            return redirect('/student?t=n');
        }
        if($request->importfile->getClientOriginalExtension() == 'csv') {
            $fileName = Str::random(10).time().'.'.$request->importfile->getClientOriginalExtension();
            $request->importfile->move(public_path('csv'), $fileName);
            $csvFile = file(public_path('csv').'/'.$fileName);
            $data = [];
            foreach($csvFile as $line) {
                $data[] = str_getcsv($line);
            }
            foreach($data as $student) {
                try{
                    $studentData = explode(';', $student[0]);
                    
                    //create a student 
                    $student = Student::create([
                        'surname' => $studentData[1],
                        'first_name' => $studentData[0],
                        'email' => $studentData[2],
                        'student_number' => $studentData[3]
                    ]);

                } catch(\Exception $e) {
                }
            }
            return redirect('/student?t=w');
            
        }
        return redirect('/student?t=o');
    }
}
