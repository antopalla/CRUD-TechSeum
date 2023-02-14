<script>
    import Modifica from '../../components/Modifica.svelte';
    import { Select, SelectItem } from "carbon-components-svelte";
</script>

<Modifica />

<Select size="xl" labelText="Carbon theme" selected="g10">
    <SelectItem value="white" text="White" />
    <SelectItem value="g10" text="Gray 10" />
    <SelectItem value="g80" text="Gray 80" />
    <SelectItem value="g90" text="Gray 90" />
    <SelectItem value="g100" text="Gray 100" />
  </Select>