-- Table: public.dash_inbound_po_new_task

-- DROP TABLE public.dash_inbound_po_new_task;

CREATE TABLE public.dash_inbound_po_new_task
(
  task_date text,
  table_source text,
  note text,
  task text,
  id serial,
  id_warehouse text
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.dash_inbound_po_new_task
  OWNER TO postgres;
