## creds
| name | type | key | notes |
|------|------|-----|-------|
| name | varchar(200) | - | Unique |
| userid | varchar(200) | PRIMARY | Referenced by logdb.username, orderchecklistitems.user, orderproductdetails.user |
| password | varchar(200) | - | Unique |

## datadb
| name | type | key | notes |
|------|------|-----|-------|
| id | int(11) | PRIMARY | Referenced by logdb.rollid |
| date | date | - | Unique |
| sku | varchar(10) | FOREIGN | References main.SKU |
| name | varchar(200) | - | Unique |
| order_detail | varchar(200) | - | Default: '-' |
| greige_width | float | - | Unique |
| finished_width | float | - | Unique |
| dcno | varchar(200) | - | Unique |
| lotno | varchar(100) | - | Unique |
| construction | varchar(200) | - | Unique |
| dyeing_unit | varchar(200) | - | Unique |
| actual_gsm | varchar(200) | - | Unique |
| rate_kg | varchar(100) | - | Unique |
| norolls | int(11) | - | Unique |
| totalmeters | float | - | Unique |
| rollno | varchar(30) | - | Unique |
| rollmeters | float | - | Unique |
| location | varchar(200) | - | Default: 'madeups' |
| currentmeters | float | - | Unique |
| remarks | varchar(2000) | - | Unique |
| status | varchar(200) | - | Default: 'in' |

## logdb
| name | type | key | notes |
|------|------|-----|-------|
| currentdate | timestamp | - | Default: current_timestamp |
| id | int(11) | PRIMARY | Unique |
| date | date | - | Unique |
| username | varchar(200) | FOREIGN | References creds.userid |
| sku | varchar(100) | FOREIGN | References main.SKU |
| lotno | varchar(100) | - | Unique |
| norolls | int(11) | - | Unique |
| rollno | varchar(100) | - | Unique |
| rollid | int(11) | FOREIGN | References datadb.id |
| inward_meters | decimal(10,0) | - | Unique |
| outward_meters | decimal(10,0) | - | Unique |
| return_meters | decimal(10,0) | - | Unique |
| remarks | varchar(500) | - | Unique |

## main
| name | type | key | notes |
|------|------|-----|-------|
| SKU | varchar(20) | PRIMARY | Referenced by datadb.sku, logdb.sku |
| Name | varchar(500) | - | Unique |
| ThreadCount | int(11) | - | Unique |
| FabricContent | varchar(1000) | - | Unique |
| WeaveDesign | varchar(1000) | - | Unique |
| Finished_WarpCount | varchar(100) | - | Unique |
| Finished_WarpComposition | varchar(100) | - | Unique |
| Finished_WeftCount | varchar(100) | - | Unique |
| Finished_WeftComposition | varchar(100) | - | Unique |
| Finished_EPI | varchar(100) | - | Unique |
| Finished_PPI | varchar(100) | - | Unique |
| Finished_Ply | varchar(100) | - | Unique |
| Greige_WarpCount | varchar(100) | - | Unique |
| Greige_WarpComposition | varchar(100) | - | Unique |
| Greige_WeftCount | varchar(100) | - | Unique |
| Greige_WeftComposition | varchar(100) | - | Unique |
| Greige_EPI | varchar(100) | - | Unique |
| Greige_PPI | varchar(100) | - | Unique |
| Greige_Ply | varchar(100) | - | Unique |
| GSM | varchar(100) | - | Unique |
| Color | varchar(100) | - | Unique |
| Finished_Width | varchar(50) | - | Nullable |
| Greige_Width | varchar(50) | - | Nullable |

## orderchecklistitems
| name | type | key | notes |
|------|------|-----|-------|
| user | varchar(250) | FOREIGN | References creds.userid |
| date | datetime | - | Default: current_timestamp |
| sales_order_no | int(250) | PRIMARY | Referenced by orderproductdetails.sales_order_no |
| buyer_code | varchar(250) | - | Unique |
| work_order_no | varchar(250) | - | Unique |
| tech_pack | varchar(500) | - | Unique |
| sample_code | varchar(250) | - | Unique |
| first_piece_inspection | varchar(2500) | - | Unique |
| trim_accessories | varchar(2000) | - | Unique |
| thread_code | varchar(250) | - | Nullable |
| washcare_label | varchar(250) | - | Nullable |
| elastic | varchar(250) | - | Nullable |
| duvet_button | varchar(250) | - | Nullable |
| embroidery_design | varchar(250) | - | Nullable |
| embroidery_thread | varchar(250) | - | Nullable |
| insert_card | varchar(250) | - | Nullable |
| tag | varchar(250) | - | Nullable |
| poly_bag | varchar(250) | - | Nullable |
| carton_box | varchar(250) | - | Nullable |
| carton_box_sticker | varchar(250) | - | Nullable |

## orderproductdetails
| name | type | key | notes |
|------|------|-----|-------|
| id | int(11) | PRIMARY | Auto_increment |
| date | datetime | - | Default: current_timestamp |
| user | varchar(100) | FOREIGN | References creds.userid |
| sales_order_no | int(11) | FOREIGN | References orderchecklistitems.sales_order_no |
| po_no | varchar(250) | - | Unique |
| buyer_product_code | varchar(250) | - | Unique |
| product_type | varchar(250) | - | Unique |
| tc | int(10) | - | Unsigned |
| design_weave | varchar(250) | - | Unique |
| color | varchar(250) | - | Unique |
| size | varchar(250) | - | Unique |
| order_qty | int(11) | - | Unique |
| cut_size | varchar(250) | - | Unique |
| cut_plan_direction | varchar(250) | - | Unique |
| cut_width | float | - | Unsigned |
| cutting_comments | varchar(1000) | - | Unique |
| consumption | float | - | Unique |
| thread_code | varchar(250) | - | Unique |
| label | varchar(500) | - | Unique |
| elastic | varchar(250) | - | Unique |
| label_placement | varchar(500) | - | Unique |