<?php

namespace App\Livewire;

use Livewire\Component;

class CarbonCalculator extends Component
{
    public $step = 1;
    public $answer;
    public $recycleValue = [];
    public $error;

    public function __construct() {
        $this->answer = array_fill(0, 12, -1);
    }

    public function nextStep(){
        if($this->answer[$this->step-1] == -1){
            $this->error = "Please answer the question!";
        } else {
            if($this->step == 9){
                // dd($this->answer[8]);
            }
            if($this->step < 12){
                $this->error = "";
                $this->step++;
            }
        }
    }

    public function prevStep(){
        if($this->step > 1){
            $this->step--;
        }
    }

    public function endQuestioner(){
        $carbon = 0;
        
        foreach($this->answer as $value){
            $carbon += (int)($value);
        }

        $carbon += 24 - count($this->recycleValue) * 4;
        return redirect()->route('carbon-calculator.result', ["carbon" => $carbon]);
    }

    public function getProgressProperty()
    {
        return floor((($this->step - 1) / 12) * 100);
    }

    public function render()
    {
        return view('livewire.carbon-calculator');
    }
}
