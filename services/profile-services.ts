import { cache } from "react";
import { createClient } from "@/utils/supabase/server";

export const syncProfile = cache(async () => {
  const supabase = await createClient();

  const {
    data: { user },
  } = await supabase.auth.getUser();
  if (!user) return null;

  const { data: existingProfile } = await supabase
    .from("profiles")
    .select("*")
    .eq("id", user.id)
    .single();

  if (!existingProfile) {
    const { data: newProfile, error } = await supabase
      .from("profiles")
      .insert({
        id: user.id,
        email: user.email || "",
        username: user.user_metadata.username || "brewer",
        is_admin: false,
        avatar_url: user.user_metadata.avatar_url || "",
      })
      .select()
      .single();

    if (error) throw new Error(error.message);
    return newProfile;
  }

  return existingProfile;
});
