<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Settings\Exchange;

class ExchangeComponent extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $ex_date, $rate_one, $rate_two, $search_date;

    public function render()
    {
        $exchange = Exchange::select('id','ex_date','rate_one','rate_two')->orderBy('id','desc')
        ->where('ex_date', 'like', '%' . $this->search_date . '%')->paginate(10);
        return view('livewire.admin.settings.exchange-component',compact('exchange'))->layout('layouts.base');
    }

    public function resetField()
    {
        $this->rate_one = '';
        $this->rate_two = '';
        $this->hiddenId = '';
    }

    public function store()
    {
        $updateId = $this->hiddenId;
        $this->validate([
            'rate_one'=>'required',
            'rate_two'=>'required',
        ],[
            'rate_one.required'=>'ກະລຸນາເພີ່ມ ເລດເງິນບາດ ກ່ອນ!',
            'rate_two.required'=>'ກະລຸນາເພີ່ມ ເລດເງິນໂດລາ ກ່ອນ!',
        ]);

        if($updateId > 0)
        {
            $exchange_update = Exchange::find($updateId);
            $exchange_update->ex_date = $this->ex_date;
            $exchange_update->rate_one = str_replace(',','',$this->rate_one);
            $exchange_update->rate_two = str_replace(',','',$this->rate_two);
            $exchange_update->save();
            $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);
        }
        else
        {
            $exchange = new Exchange;
            $exchange->ex_date = $this->ex_date;
            $exchange->currency_one = 'THB';
            $exchange->rate_one = str_replace(',','',$this->rate_one);
            $exchange->currency_two = 'USD';
            $exchange->rate_two = str_replace(',','',$this->rate_two);
            $exchange->result = '*';
            $exchange->save();
            $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        }
        $this->resetField();
    }

    public function edit($ids)
    {
        $singleData = Exchange::find($ids);
        $this->ex_date = $singleData->ex_date;
        $this->rate_one = $singleData->rate_one;
        $this->rate_two = $singleData->rate_two;
        $this->hiddenId = $singleData->id;
    }

    public function showDestroy($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Exchange::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $exchange = Exchange::find($ids);
        // if($exchange->disname()->exists())
        // {
        //     $this->dispatchBrowserEvent('hide-modal-delete');
        //     $this->emit('alert', ['type' => 'warning', 'message' => 'ບໍ່ສາມາດລຶບໄດ້ ເພາະຂໍ້ມູນນີ້ມີຜູກກັບຕາຕະລາງອື່ນ!']);
        // }else
        // {
            $exchange->delete();
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
        // }
    }
}
