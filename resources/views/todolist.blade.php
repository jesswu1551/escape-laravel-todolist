<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Todo List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-3">
            <div class="max-w-xl mb-4">
                <form>
                    <label class="block mb-2">
                        <span class="block text-sm font-medium text-slate-700">
                            標題
                        </span>
                        <input type="text" id="title" name="title" class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1" placeholder="標題" />
                    </label>
                    <label class="block mb-2">
                        <span class="block text-sm font-medium text-slate-700">
                        描述
                        </span>
                        <textarea type="text" id="description" name="description" class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1" placeholder="description"></textarea>
                    </label>
                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="createBtn" onclick="addTodo()">新增</button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-fixed">
                        <thead>
                        <tr>
                            <th class="w-2/12 px-4 py-2">標題</th>
                            <th class="w-4/12 px-4 py-2">描述</th>
                            <th class="w-1/12 px-4 py-2">狀態</th>
                            <th class="w-2/12 px-4 py-2">動作</th>
                            <th class="w-1/12 px-4 py-2">建立時間</th>
                            <th class="w-1/12 px-4 py-2">更新時間</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($todos as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                @if ($task->completed)
                                <td class="text-center text-green-600">完成</td>
                                @else
                                <td class="text-center text-gray-400">未完成</td>
                                @endif
                                <td>
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="updateStatusBtn"
                                            onclick="updateStatus('{{ $task->id }}', '{{ $task->completed }}')">
                                        標示{{ $task->completed ? '未完成' : '完成' }}</button>
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" id="deleteTodoBtn" onclick="deleteTodo('{{ $task->id }}')">刪除</button>
                                </td>
                                <td>{{ $task->created_at }}</td>
                                <td>{{ $task->updated_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $todos->links() }}
        </div>
    </div>

    <script>
        function addTodo() {
            axios.post('{{ route('todolist.create') }}', {
                title: document.getElementById('title').value,
                description: document.getElementById('description').value
            })
                .then(function (response) {
                    console.log(response);
                    window.location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function updateStatus(todo_id, current_status) {
            axios.put('{{ route('todolist.update', '') }}/' + todo_id, {
                completed: current_status === '1' ? '0' : '1'
            })
                .then(function (response) {
                    console.log(response);
                    window.location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function deleteTodo(todo_id) {
            axios.delete('{{ route('todolist.delete', '') }}/' + todo_id)
                .then(function (response) {
                    console.log(response);
                    window.location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    </script>
</x-app-layout>
