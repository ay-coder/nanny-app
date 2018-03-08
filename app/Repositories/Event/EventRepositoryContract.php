<?php namespace App\Repositories\Event;

interface EventRepositoryContract
{
	/**
	 * Create Menu Item
	 *
	 * @param  $input
	 * @return mixed
	 */
	public function create($input);

	/**
	 * Update Menu Item
	 *
	 * @param  $id
	 * @param  $input
	 * @return mixed
	 */
	public function update($id, $input);

	/**
	 * Destroy Menu Item
	 *
	 * @param  $id
	 * @return mixed
	 */
	public function destroy($id);

	/**
	 * Get All
	 * 
	 * @return [type] [description]
	 */
	public function getAll($order_by = 'id', $sort = 'asc');

	/**
	 * Get By Id
	 * 
	 * @param int $id
	 * @return collection
	 */
    public function getById($id = null);
}