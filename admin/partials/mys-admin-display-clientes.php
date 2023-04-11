<div class="wrap">
    <h1 class="wp-heading-inline">Contacto clientes</h1>
    
    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Seleccionar todos</label><input id="cb-select-all-1" type="checkbox"></td>
                <th scope="col" id="name_cliente" class="manage-column column-name-cliente column-primary sortable desc"><a href="#"><span>Nombre del cliente</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="telefono_cliente" class="manage-column column-telefono sortable desc"><a href="#"><span>Tel&eacute;fono</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="correo_cliente" class="manage-column column-correo sortable desc"><a href="#"><span>Correo</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="sku_product" class="manage-column column-sku-product sortable desc"><a href="#"><span>SKU producto</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="date" class="manage-column column-date sortable desc"><a href="#"><span>Fecha</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="date" class="manage-column column-delete sortable desc"><a href="#"><span>Borrar</span><span class="sorting-indicator"></span></a></th>
            </tr>
        </thead>

        <tbody id="the-list">

            <?php

            $list_clientes = $this->get_list_clientes();

            foreach ($list_clientes as $cliente) {
                ?>
                <tr id="post-<?php echo $cliente->id; ?>" class="post-<?php echo $cliente->id; ?>hentry">

                    <!-- Check -->
                    <th scope="row" class="check-column">
                        <input id="cl-select-<?php echo $cliente->id; ?>" type="checkbox" name="" value="<?php echo $cliente->id; ?>">
                    </th>

                    <!-- Nombre cliente -->
                    <td class="title column-name-cliente column-primary" data-colname="Nombre del cliente">
                        <strong><?php echo $cliente->nombre_cliente; ?></strong>
                    </td>

                    <!-- Telefono -->
                    <td class="tel column-tel" data-colname="Telefono">
                        <?php echo $cliente->telefono_cliente; ?>
                    </td>

                    <!-- Correo -->
                    <td class="correo column-correo" data-colname="Correo">
                        <?php echo $cliente->correo_cliente; ?>
                    </td>

                    <!-- Referencia del producto -->

                    <?php 
                    $item_product = wc_get_product($cliente->sku_product);
                    ?>
                    
                    <td class="ref column-ref" data-colname="SKU producto">
                        <strong><span><a target="_blank" href="<?php echo get_permalink($cliente->sku_product); ?>"><?php echo $item_product->get_sku(); ?></a></span></strong>
                    </td>

                    <!-- Fecha contacto -->
                    <td class="date column-date" data-colname="Fecha">
                        <?php echo $cliente->date_stmp; ?>
                    </td>

                    <!-- Boton para eliminar registro -->
                    <td class="delete column-delete" data-colname="Acción">
                        <input type="submit" name="delete_item" id="btn-delete-item" class="button button-primary button-large delete-item" data-registro_id="<?php echo $cliente->id; ?>" value="Borrar">
                    </td>
                    </tr>
                <?php
            }

            ?>

            
        </tbody>

        <tfoot>
            <tr>
                <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Seleccionar todos</label><input id="cb-select-all-1" type="checkbox"></td>
                <th scope="col" id="name_cliente" class="manage-column column-name-cliente column-primary sortable desc"><a href="#"><span>Nombre del cliente</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="telefono_cliente" class="manage-column column-telefono sortable desc"><a href="#"><span>Tel&eacute;fono</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="correo_cliente" class="manage-column column-correo sortable desc"><a href="#"><span>Correo</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="sku_product" class="manage-column column-sku-product sortable desc"><a href="#"><span>SKU producto</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="date" class="manage-column column-date sortable desc"><a href="#"><span>Fecha</span><span class="sorting-indicator"></span></a></th>
                <th scope="col" id="date" class="manage-column column-delete sortable desc"><a href="#"><span>Borrar</span><span class="sorting-indicator"></span></a></th>
            </tr>
        </tfoot>

    </table>
</div>