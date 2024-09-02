<?php

namespace IbrahimBougaoua\Filawidget\Pages;

use Filament\Pages\Page;
use IbrahimBougaoua\Filawidget\Models\Page as ModelsPage;
use IbrahimBougaoua\Filawidget\Models\Widget;
use IbrahimBougaoua\Filawidget\Models\WidgetArea;
use IbrahimBougaoua\Filawidget\Services\PageService;
use Illuminate\View\View;
use Illuminate\Http\Request;

class Appearance extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

    protected static string $view = 'filawidget::pages.appearance';

    public $filter = 'widgets';
    public $pagesOrder = [];
    public $subPagesOrder = [];
    public $widgetsOrder = [];
    public $widgetAreasOrder = [];
    public $pages = [];
    public $widgets = [];
    public $widgetAreas = [];
    public $nbrWidgetAreas = 0;
    public $nbrPages = 0;

    public static function getNavigationGroup(): ?string
    {
        return 'Appearance';
    }

    public function mount(Request $request)
    {
        // Get the 'filter' query parameter, default to 'widgets' if not provided
        $this->filter = $request->query('filter', 'widgets');

        // Get ordered widgets from the database
        $this->pages = PageService::getAllPages();
        $this->widgets = Widget::ordered()->get();
        $this->widgetAreas = WidgetArea::ordered()->withOrderedWidgets()->get();
        $this->nbrWidgetAreas = $this->widgetAreas ? count($this->widgetAreas) : 0;
        $this->nbrPages = PageService::counts();
    }

    public function updateOrder()
    {
        // Validate the input to ensure it's an array
        if (!is_array($this->widgetsOrder) || !is_array($this->widgetAreasOrder)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid input.'], 400);
        }

        // Update widget order in the database
        foreach ($this->widgetAreasOrder as $index => $widgetAreaId) {
            WidgetArea::where('id', $widgetAreaId)->update(['order' => $index + 1]);
        }

        foreach ($this->widgetsOrder as $index => $widgetId) {
            Widget::where('id', $widgetId)->update(['order' => $index + 1]);
        }

        // Refresh the widgets list after updating
        //$this->widgets = Widget::ordered()->get();
        $this->widgetAreas = WidgetArea::ordered()->withOrderedWidgets()->get();

        if($this->widgetAreasOrder != [])
            session()->flash('areaStatus', 'Area order successfully updated.');

        if($this->widgetsOrder != [])
            session()->flash('widgetStatus', 'Widgets order successfully updated.');
    }

    public function updatePageOrder()
    {
        // Validate the input to ensure it's an array
        if (!is_array($this->pagesOrder) || !is_array($this->subPagesOrder)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid input.'], 400);
        }

        // Update widget order in the database
        foreach ($this->pagesOrder as $index => $pageId) {
            ModelsPage::father()->where('id', $pageId)->update(['order' => $index + 1]);
        }

        // Update widget order in the database
        foreach ($this->subPagesOrder as $index => $pageId) {
            ModelsPage::child()->where('id', $pageId)->update(['child_order' => $index + 1]);
        }

        // Refresh the widgets list after updating
        $this->pages = PageService::getAllPages();

        session()->flash('pageStatus', 'Pages order successfully updated.');
    }
    
    public function hideAlert()
    {
        session()->flash('pageStatus', null);
        session()->flash('areaStatus', null);
        session()->flash('widgetStatus', null);
    }

    public function handleOrderUpdate()
    {
        if ($this->filter === 'widgets') {
            $this->updateOrder();
        } else {
            $this->updatePageOrder();
        }
    }

    public function getHeader(): ?View
    {
        return view('filawidget::components.header',[
            'filter' => $this->filter,
        ]);
    }

    public function getFooter(): ?View
    {
        return view('filawidget::components.footer');
    }
}
