export const setMetadata = (htmlUrl, imageUrl, htmlTitle, pageTitle, pageDescription) => {
  const metaData = {
    title: htmlTitle + ' | ' + pageTitle,
    meta: {
      description: {
        name: 'description',
        content: pageDescription
      },
      og_title: {
        property: 'og:title',
        content: htmlTitle + ' | ' + pageTitle
      },
      og_description: {
        property: 'og:description',
        content: pageDescription
      },
      og_url: {
        property: 'og:url',
        content: htmlUrl
      },
      og_image: {
        property: 'og:image',
        content: imageUrl
      }
    }
  }
  return metaData
}
