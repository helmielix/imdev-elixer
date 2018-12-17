--PROCEDURE xxuflx_po_rcv_trx_intf (
--      p_po_number   IN       VARCHAR2,
--      p_po_orgid    IN       NUMBER,
--      p_group_id    OUT      NUMBER                                     --7937
--   )
--   IS

declare
      dest_org_id                 NUMBER         := 141;

      CURSOR get_po_det
      IS
         SELECT DISTINCT poh.po_header_id, poh.vendor_id, poh.vendor_site_id,
                         poh.agent_id, pll.ship_to_organization_id,
                         poh.attribute15, poh.last_update_date,
                         poh.last_updated_by, poh.creation_date,
                         poh.created_by
                    FROM po_headers_all poh,
                         po_lines_all pol,
                         po_line_locations_all pll
                   WHERE 1 = 1
                     AND poh.po_header_id = pol.po_header_id
                     AND pol.po_header_id = pll.po_header_id
                     AND pol.po_line_id = pll.po_line_id
                     AND poh.org_id = 141
                     -- AND poh.attribute15 = '541600194-001'
                     AND poh.segment1 = :p_po_number
                     AND NOT EXISTS (
                            SELECT 1
                              FROM rcv_shipment_headers rcv,
                                   rcv_shipment_lines rsl
                             WHERE rcv.attribute15 = poh.attribute15
                               AND rcv.shipment_header_id =
                                                        rsl.shipment_header_id);

      CURSOR get_po_line_det                         --(p_po_header_id NUMBER)
      IS
         SELECT poh.vendor_id, pol.item_id, pol.attribute13 order_line_id,
                pol.item_id inventory_item_id, pol.attribute1 roll_number,
                pll.*, mp.organization_id, mp.organization_code
           FROM po_headers_all poh,
                po_lines_all pol,
                po_line_locations_all pll,
                mtl_parameters mp
          WHERE 1 = 1
            AND poh.po_header_id = pol.po_header_id
            AND pol.po_header_id = pll.po_header_id
            AND pol.po_line_id = pll.po_line_id
            AND pll.ship_to_organization_id = mp.organization_id
            AND poh.segment1 = :p_po_number
            AND poh.org_id = 141;

      --
      lv_group_id                 NUMBER         := 0;
      --xxuflex_rcv_group_id.NEXTVAL;
      --
      lv_auto_transact_code       VARCHAR2 (10)  := 'DELIVER';
      lv_processing_status_code   VARCHAR2 (10)  := 'PENDING';
      lv_validation_flag          VARCHAR2 (1)   := 'Y';
      lv_return                   BOOLEAN;
      lv_req_status1              VARCHAR2 (200);
      lv_request_id               NUMBER         := fnd_global.conc_request_id;
      custom_exception            EXCEPTION;
      lv_phase                    VARCHAR2 (100);
      lv_dev_phase                VARCHAR2 (100);
      lv_dev_status               VARCHAR2 (100);
      lv_message                  VARCHAR2 (100);
      lv_rcv_number               VARCHAR2 (100);
      v_packing_list_num          NUMBER;
      xx_rcv_created              EXCEPTION;
      lv_seq                      NUMBER         := 0;
      lv_roll_number              VARCHAR2 (100);
      lv_item_code                VARCHAR2 (100);
   BEGIN
       --
     
      BEGIN
         SELECT DISTINCT attribute15
                    INTO v_packing_list_num
                    FROM po_headers_all
                   WHERE segment1 = :p_po_number;

         SELECT MAX (receipt_num)
           INTO lv_rcv_number
           FROM rcv_shipment_headers rsh, rcv_shipment_lines rsl
          WHERE 1 = 1
            AND rsh.attribute15 = v_packing_list_num
            AND rsh.shipment_header_id = rsl.shipment_header_id;
      EXCEPTION
         WHEN OTHERS
         THEN
            lv_rcv_number := NULL;
      END;

      IF lv_rcv_number IS NOT NULL
      THEN
         RAISE xx_rcv_created;
      END IF;

      FOR l_hdr_rec IN get_po_det
      LOOP
          --
         -- fnd_file.put_line('insert shipment header rec');
         lv_group_id := rcv_interface_groups_s.NEXTVAL;

         --
         INSERT INTO xmnc.rcv_headers_interface
                     (header_interface_id, GROUP_ID,
                      processing_status_code, transaction_type,
                      validation_flag, ship_to_organization_id,
                      last_update_date, last_updated_by,
                      creation_date, created_by,
                      receipt_source_code, vendor_id,
                      vendor_site_id, employee_id, expected_receipt_date,
                      auto_transact_code, attribute15
--                      shipment_num
                     )
              VALUES (rcv_headers_interface_s.NEXTVAL, lv_group_id,
                      lv_processing_status_code, 'NEW',
                      lv_validation_flag, l_hdr_rec.ship_to_organization_id,
                      l_hdr_rec.last_update_date, l_hdr_rec.last_updated_by,
                      l_hdr_rec.creation_date, l_hdr_rec.created_by,
                      'VENDOR',                                 --'INVENTORY',
                               l_hdr_rec.vendor_id,
                      l_hdr_rec.vendor_site_id, l_hdr_rec.agent_id, SYSDATE,
                      lv_auto_transact_code, l_hdr_rec.attribute15
--                      xxuflx_shipment_num_s.NEXTVAL
                     );

         --
         FOR line_rec IN get_po_line_det            --(l_hdr_rec.po_header_id)
         LOOP
            -- fnd_file.put_line('insert shipment line rec');

            --
            INSERT INTO xmnc.rcv_transactions_interface
                        (interface_transaction_id, GROUP_ID,
                         last_update_date,
                         last_updated_by, creation_date,
                         created_by, transaction_type, transaction_date,
                         processing_status_code, processing_mode_code,
                         transaction_status_code, quantity,
                         --quantity_shipped,
                         unit_of_measure, item_id,
                         auto_transact_code, ship_to_location_id,
                         receipt_source_code, vendor_id,
                         source_document_code, po_header_id, po_line_id,
                         po_line_location_id, destination_type_code,
                         header_interface_id,
                         to_organization_id, org_id,
                         primary_unit_of_measure,
                                                 --category_id,
                                                 routing_header_id,
                         validation_flag, subinventory,
                         locator_id
--                         shipment_num
                        )
                 VALUES (rcv_transactions_interface_s.NEXTVAL,
                                                              ---INTERFACE_TRANSACTION_ID
                                                              lv_group_id,
                         line_rec.last_update_date,
                         line_rec.last_updated_by, line_rec.creation_date,
                         line_rec.created_by, 'RECEIVE',   ---TRANSACTION_TYPE
                                                        SYSDATE,
                       
                         ----TRANSACTION_DATE
                         'PENDING',               ------PROCESSING_STATUS_CODE
                                   'BATCH',
                       
                         ----------------PROCESSING_MODE_CODE
                         'PENDING',      --------------TRANSACTION_STATUS_CODE
                                   line_rec.quantity,            -----QUANTITY
                         --line_rec.quantity_shipped, ----quantity_shipped
                         line_rec.unit_meas_lookup_code,
                                                        ------UNIT OF MESUREE
                                                        line_rec.item_id,
                       
                         ----ITEM_ID
                         'DELIVER',
                                   -----------------AUTO_TRANSACT_CODE
                                   line_rec.ship_to_location_id,
                       
                         ------------------SHIP_TO_LOCATION_ID
                         'VENDOR',
                                  -----------RECEIPT_SOURCE_CODE
                                  line_rec.vendor_id,
                       
                         --------------VENDOR_ID
                         'PO',
                              -------------------SOURCE_DOCUMENT_CODE
                              line_rec.po_header_id,
                                                    ----------------------PO_Header_id
                                                    line_rec.po_line_id,
                         ---------------------po_line_id
                         line_rec.line_location_id,
                                                    -------------------po_lin_location
                         'INVENTORY',
                         -------------DESTINATION_TYPE_COD
                         rcv_headers_interface_s.CURRVAL,
                         ------HEADER_ID_INTERFACE
                         line_rec.ship_to_organization_id, dest_org_id,
                         ----ORG_ID
                         line_rec.unit_meas_lookup_code,
                                                        --l_category_id,
                         3,
                         'Y', line_rec.organization_code,
                         (SELECT inventory_location_id
                            FROM mtl_item_locations msi, mtl_parameters mp
                           WHERE msi.organization_id = mp.organization_id
                             AND mp.organization_code =
                                                    line_rec.organization_code
                             AND subinventory_code =
                                                    line_rec.organization_code
                             AND TRUNC (NVL (disable_date, SYSDATE)) >=
                                                               TRUNC (SYSDATE)
                             AND ROWNUM <= 1)
--                         xxuflx_shipment_num_s.CURRVAL
                        );

            --

            --
            BEGIN
               SELECT DISTINCT segment1
                          INTO lv_item_code
                          FROM mtl_system_items_b
                         WHERE inventory_item_id = line_rec.item_id;
            EXCEPTION
               WHEN NO_DATA_FOUND
               THEN
                  lv_item_code := NULL;
            END;

         

            --
            lv_roll_number := NVL (line_rec.roll_number, NULL);

            INSERT INTO mtl_transaction_lots_interface
                        (transaction_interface_id, source_code, product_code,
                         product_transaction_id,
                         last_update_date, last_updated_by,
                         creation_date, created_by,
                         lot_number, transaction_quantity,
                         primary_quantity, process_flag
                        )
                 VALUES (mtl_material_transactions_s.NEXTVAL
                                                            --transaction_interface_id
            ,            'PO', 'RCV',                          -- product_code
                         rcv_transactions_interface_s.CURRVAL,
                         line_rec.last_update_date, line_rec.last_updated_by,
                         line_rec.creation_date, line_rec.created_by,
                         lv_roll_number                           --LOT_NUMBER
                                       , line_rec.quantity
                                                          --TRANSACTION_QUANTITY
            ,
                         line_rec.quantity
                                          --primary_quantity,
            ,            1
                        );

            --
            COMMIT;
             --
            -- fnd_file.put_line('data inserted for group id ' || lv_group_id);
--            p_group_id := lv_group_id;
         END LOOP;
      END LOOP;

      -- fnd_file.put_line('all shipment data inserted');
      COMMIT;
   EXCEPTION
      WHEN OTHERS
      THEN
         fnd_file.put_line (fnd_file.LOG, SQLERRM);
   END;