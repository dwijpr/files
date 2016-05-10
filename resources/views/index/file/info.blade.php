<div class="panel panel-default file-info">
    <div class="panel-body">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2">
                        File Info
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Name
                    </td>
                    <td>
                        {{ $browse->item->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Type
                    </td>
                    <td>
                        {{ $browse->item->mimeType }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Size
                    </td>
                    <td>
                        {{ human_filesize($browse->item->size) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Modified
                    </td>
                    <td>
                        {{ read_time('U~'.$browse->item->modified) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
