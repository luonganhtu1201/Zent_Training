<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Service
{
	public function index(Request $request)
	{
		try {

	        return;
	    } catch (Exception $e) {
			Log::error("ERROR - ", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

            throw $e;
		}
	}

	public function show($id)
	{
		try {

			return;
		} catch (Exception $e) {
			Log::error("ERROR - ", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

            throw $e;
		}
	}

	public function store(Request $request)
	{
		try {

			return;
		} catch (Exception $e) {
			Log::error("ERROR - ", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

            throw $e;
		}
	}

	public function update(Request $request, $id)
	{
		try {

			return;
		} catch (Exception $e) {
			Log::error("ERROR - ", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

            throw $e;
		}
	}

	public function destroy($id)
	{
		try {

			return;
		} catch (Exception $e) {
			Log::error("ERROR - ", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

            throw $e;
		}
	}
}
