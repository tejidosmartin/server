<?php 


    $conn = mysqli_connect('localhost', 'shakar', 'tWbh0H#ov#RG4AJ%v', 'tienda');

    $query = 'SELECT * FROM `producto`';
    $result = mysqli_query($conn, $query);

    echo '<table class="table table-striped" border="1">';
        echo '<thead>
                    <tr>
                        <th>id</th>
                        <th>Asunto</th>
                        <th>Asunto</th>
                        <th>Asunto</th>
                        <th>Asunto</th>
                        <th>Asunto</th>
                        <th>Asunto</th>
                        <th>Asunto</th>
                        <th>Asunto</th>
                    </tr>
            </thead>';

        while($value = $result->fetch_array(MYSQLI_ASSOC)){
            echo '<tr>';
            foreach($value as $element){
                echo '<td>' . $element . '</td>';
            }

            echo '</tr>';
        }
    echo '</table>';

    $result->close();
    mysqli_close($conn);
?>