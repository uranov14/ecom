<div class="form-group">
    <label for="parent_id">Select Category Level</label>
    <select class="form-control"  name="parent_id" id="parent_id">
        <option 
            value="0"
            @if (isset($categorydata['parent_id']) && $categorydata['parent_id'] == 0)
                selected
            @endif
        >
            Main Category
        </option> 
        @if (!empty($getCategories))
            @foreach ($getCategories as $category)
                <option 
                    value="{{ $category['id'] }}"
                    @if (isset($categorydata['parent_id']) && $categorydata['parent_id'] == $category['id'])
                        selected
                    @endif
                >
                    {{ $category['category_name'] }}
                </option>

                @if (!empty($category['subcategories']))
                    @foreach ($category['subcategories'] as $subcategory)
                    <option 
                        value="{{ $subcategory['id'] }}"
                        @if (isset($subcategory['parent_id']) && $subcategory['parent_id'] == $subcategory['id'])
                            selected
                        @endif
                    >
                        &nbsp;&raquo;&nbsp;{{ $subcategory['category_name'] }}
                    </option>   
                    @endforeach  
                @endif  

            @endforeach  
        @endif 
    </select>
</div>