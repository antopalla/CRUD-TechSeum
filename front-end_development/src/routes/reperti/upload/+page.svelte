<script>
    import { v4 as uuidv4 } from 'uuid';
    import { writeFile } from 'fs/promises';
    import { join } from 'path';

export async function post(req) {
    console.log("ciao")
    const { file } = req.body;
    const fileName = uuidv4() + '.' + file.name.split('.').pop();
    const filePath = join(process.cwd(), 'public', 'uploads', fileName);

    await writeFile(filePath, file.data);

    return {
        status: 200,
        body: {
        message: 'File uploaded successfully!',
        url: `/static/${fileName}`
        }
    };
}

</script>