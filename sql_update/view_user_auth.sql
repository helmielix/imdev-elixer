-- View: public.user_auth

-- DROP VIEW public.user_auth;

CREATE OR REPLACE VIEW public.user_auth AS 
 SELECT "user".username,
    "user".email,
    auth_item_child.child,
    "user".id AS id_user
   FROM "user"
     LEFT JOIN auth_assignment ON "user".id = auth_assignment.user_id::integer
     LEFT JOIN auth_item_child ON auth_assignment.item_name::text = auth_item_child.parent::text;

ALTER TABLE public.user_auth
  OWNER TO postgres;
GRANT ALL ON TABLE public.user_auth TO postgres;
