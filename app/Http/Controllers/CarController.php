<?php 

namespace App\Http\Controllers;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
class CarController{
    public function index(){
        $cars = Car::orderBy('updated_at', 'DESC')->get();

        $cars = $cars->map(function ($car) {
            // Extract image paths from the images collection
            $imagePaths = $car->images->pluck('url')->toArray();
            
            // Return an array with car details and image paths
            return [
                'id' => $car->id,
                'model' => $car->model,
                'brand' => $car->brand,
                'fuel' => $car->fuel,
                'seat' => $car->seat,
                'price' => $car->price,
                'gearbox' => $car->gearbox,
                'color' => $car->color,
                'top_speed' => (double) $car->top_speed ,
                'rent_period' => $car->rent_period,
                'images' => $imagePaths,
            ];
        });

        return response()->json($cars);
    }

    public function store(Request $request){
        $rules = [
            'model'     => ['required' , 'string' , 'max:255', 'unique:cars,model'],
            'brand'     => ['required', 'string', 'max:100'],
            'fuel'      => ['required', 'string', 'max:100'],
            'price'     => ['required', 'integer'],
            'seat'      => ['required', 'integer'],
            'gearbox'   => ['required','integer'],  
            'color'     => ['required', 'string'],
            'images'    => ['required', 'array'],
            'images'    => ['required']
        ];

        $validator = \Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->getMessageBag()
            ],422);
        }

        if($validator->passes()){

            $car = new Car();
            $car->model = $request->model;
            $car->fuel = $request->fuel;
            $car->brand = $request->brand;
            $car->price = $request->price;
            $car->seat = $request->seat;
            $car->color = $request->color;
            $car->gearbox = $request->gearbox;
            $car->rent_period =  $request->rent_period;
            $car->top_speed = $request->top_speed;
            $car->save();

            $urls = $request->images;

            foreach($urls as $url){
                $car->images()->create([
                    'url' => $url
                ]);
            }

            return response()->json([
                'message' => 'Car has been created.',
                'data' => $car
            ],201);
        }
    }

    public function show($id){
        try{
            $car = Car::where('id', '=', $id)->firstOrFail();
            $car->image = url($car->image);
            return response()->json([
                'data' => $car
            ]);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'error' => [
                    'message' => 'Car not found.'
                ]
            ],404);
        }
    }

    public function update($id, Request $request){
        try{
            $car = Car::where('id', '=', $id)->firstOrFail();
            $rules = [
                'model'     => ['required' , 'string' , 'max:255', 'unique:cars,brand,' . $car->id],
                'brand'     => ['required', 'string', 'max:100'],
                'fuel'      => ['required', 'string', 'max:100'],
                'price'     => ['required', 'integer'],
                'path'      => ['nullable'],
                'gearbox'   => ['required','integer'],  
                'color'     => ['required', 'string'],
                'images'     => ['nullable']
            ];

            $validator = \Validator::make($request->all(), $rules);

            if($validator->fails()){
                return response()->json([
                    'errors' => $validator->getMessageBag()
                ],422);
            }

            if($validator->passes()){
                $car->model = $request->model;
                $car->fuel = $request->fuel;
                $car->brand = $request->brand;
                $car->price = $request->price;
                $car->seat = $request->seat;
                $car->color = $request->color;
                $car->gearbox = $request->gearbox;
                $car->rent_period =  $request->rent_period;
                $car->top_speed = $request->top_speed;
                $car->save();
    
                $urls = $request->images ?? [];
    
                foreach($urls as $url){
                    $car->images()->create([
                        'url' => $url
                    ]);
                }
                return response()->json([
                    'message' => 'Car is successfully updated.'
                ]);
            }
        }catch(ModelNotFoundException $e){
            return response()->json([
                'error' => [
                    'message' => 'Car not found.'
                ]
            ],404);
        }
    }

    public function destroy($id){
        try{
            $car = Car::where('id' , '=' , $id)->firstOrFail();
            if(file_exists($car->image)){
                unlink($car->image);
            }
            $car->delete();
            return response()->json([
                'message' => 'Car is successfully deleted'
            ]);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'error' => [
                    'message' => 'Car not found.'
                ]
            ],404);
        }
    }
}