<style>
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }

    .image-container {
        position: relative;
        width: 100%;
        padding-bottom: 100%; /* Create a square aspect ratio */
    }

    .image {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .like-form {
        position: absolute;
        bottom: -30px; /* Adjust the value as needed */
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        width: 100%;
    }

    .like-button {
        background-color: #fff;
        border: 1px solid #ccc;
        padding: 8px 16px;
        cursor: pointer;
    }

    .like-count {
        display: inline-block;
        margin-left: 5px;
    }
</style>


<div class="image-grid">
    @foreach (Storage::disk('public')->files('uploads') as $image)
        @php
            $imageName = basename($image);
        @endphp
        <div class="image-container">
            <img src="{{ asset('storage/' . $image) }}" alt="Image" class="image">
            <form action="{{ route('like.store', $imageName) }}" method="POST" class="like-form">
                @csrf
                <button type="submit" class="like-button">Like</button>
                <span class="like-count">{{ session('likeCount', 0) }}</span>
            </form>
        </div>
    @endforeach
</div>
