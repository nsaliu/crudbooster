<?php 
	$datatable = $form['datatable'];
	$datatableSeparator = !empty($form['datatable_separator']) ? $form['datatable_separator'] : ' ';
	if($datatable && !$form['relationship_table']) {

		$datatable = explode(',', $datatable);
		$table = $datatable[0];
		$field = $datatable[1];

		$separator = '';
		$output = [];

        $output[] = CRUDBooster::first($table,['id'=>$value])->$field;

		if (!empty($datatable[2]))
        {
            $separator = $datatableSeparator;
            $field1 = $datatable[2];
            $output[] = CRUDBooster::first($table,['id'=>$value])->$field1;
        }

		echo join($separator, $output);
	}

	if($datatable && $form['relationship_table']) {
		$datatable_table = explode(',',$datatable)[0];
		$datatable_field = explode(',',$datatable)[1];
		$foreignKey = CRUDBooster::getForeignKey($table,$form['relationship_table']);	
		$foreignKey2 = CRUDBooster::getForeignKey($datatable_table,$form['relationship_table']);	
		$ids = DB::table($form['relationship_table'])->where($foreignKey,$id)->pluck($foreignKey2)->toArray();

		$tableData = DB::table($datatable_table)->whereIn('id',$ids)->pluck($datatable_field)->toArray();
		
		echo implode(", ",$tableData);
	}

	if($form['dataenum']) {
		echo $value;
	}


?>