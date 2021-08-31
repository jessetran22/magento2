<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-5005: Admin is able to configure product placeholder images")
 * @Description("Admin should be able to configure the images used for product image placeholders. The configured placeholders should be seen on the frontend when an image has no image.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminConfigureProductImagePlaceholderTest.xml<br>")
 * @TestCaseId("MC-5005")
 * @group configuration
 */
class AdminConfigureProductImagePlaceholderTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("category", "hook", "ApiCategory", [], []); // stepKey: category
		$I->comment("Create product with no images");
		$I->createEntity("productNoImages", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: productNoImages
		$I->comment("Create product with small, base, and thumbnail image");
		$I->createEntity("productWithImages", "hook", "ApiSimpleProduct", ["category"], []); // stepKey: productWithImages
		$I->createEntity("productImage", "hook", "ApiProductAttributeMediaGalleryEntryTestImage", ["productWithImages"], []); // stepKey: productImage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Unset product image placeholders");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/catalog/"); // stepKey: goToCatalogConfigurationPageAfter
		$I->waitForPageLoad(30); // stepKey: waitForConfigurationPageLoadAfter
		$I->conditionalClick("#catalog_placeholder-head", "#catalog_placeholder_image_placeholder", false); // stepKey: openPlaceholderSectionAfter
		$I->waitForPageLoad(10); // stepKey: openPlaceholderSectionAfterWaitForPageLoad
		$I->waitForElementVisible("#catalog_placeholder_image_placeholder", 30); // stepKey: waitForPlaceholderSectionOpenAfter
		$I->waitForPageLoad(10); // stepKey: waitForPlaceholderSectionOpenAfterWaitForPageLoad
		$I->comment("Delete base placeholder");
		$I->checkOption("#catalog_placeholder_image_placeholder_delete"); // stepKey: checkDeleteBasePlaceholder
		$I->comment("Delete small placeholder");
		$I->checkOption("#catalog_placeholder_small_image_placeholder_delete"); // stepKey: checkDeleteSmallPlaceholder
		$I->comment("Delete thumbnail placeholder");
		$I->checkOption("#catalog_placeholder_thumbnail_placeholder_delete"); // stepKey: checkDeleteThumbnailPlaceholder
		$I->comment("Save config to delete placeholders");
		$I->click("#save"); // stepKey: saveConfigWithPlaceholders
		$I->waitForPageLoad(30); // stepKey: saveConfigWithPlaceholdersWaitForPageLoad
		$I->comment("See placeholders are empty");
		$I->conditionalClick("#catalog_placeholder-head", "#catalog_placeholder_image_placeholder", false); // stepKey: openPlaceholderSection2
		$I->waitForPageLoad(10); // stepKey: openPlaceholderSection2WaitForPageLoad
		$I->waitForElementVisible("#catalog_placeholder_image_placeholder", 30); // stepKey: waitForPlaceholderSectionOpen2
		$I->waitForPageLoad(10); // stepKey: waitForPlaceholderSectionOpen2WaitForPageLoad
		$I->dontSeeElement("#catalog_placeholder_image_placeholder_image"); // stepKey: dontSeeBaseImageSet
		$I->dontSeeElement("#catalog_placeholder_small_image_placeholder_image"); // stepKey: dontSeeSmallImageSet
		$I->dontSeeElement("#catalog_placeholder_thumbnail_placeholder_image"); // stepKey: dontSeeThumbnailImageSet
		$I->dontSeeElement("#catalog_placeholder_swatch_image_placeholder_image"); // stepKey: dontSeeSwatchImageSet
		$I->comment("Delete prerequisite entities");
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("productNoImages", "hook"); // stepKey: deleteProductNoImages
		$I->deleteEntity("productWithImages", "hook"); // stepKey: deleteProductWithImages
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Catalog"})
	 * @Stories({"Configure product placeholder images"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigureProductImagePlaceholderTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToAdminArea] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminArea
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminArea
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminArea
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminArea
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminAreaWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminArea
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminArea
		$I->comment("Exiting Action Group [loginToAdminArea] AdminLoginActionGroup");
		$I->comment("Admin area: configure Product Image Placeholders");
		$I->comment("Configure product image placeholders in store config");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/catalog/"); // stepKey: goToCatalogConfigurationPage
		$I->waitForPageLoad(30); // stepKey: waitForConfigurationPageLoad1
		$I->conditionalClick("#catalog_placeholder-head", "#catalog_placeholder_image_placeholder", false); // stepKey: openPlaceholderSection1
		$I->waitForPageLoad(10); // stepKey: openPlaceholderSection1WaitForPageLoad
		$I->waitForElementVisible("#catalog_placeholder_image_placeholder", 30); // stepKey: waitForPlaceholderSectionOpen1
		$I->waitForPageLoad(10); // stepKey: waitForPlaceholderSectionOpen1WaitForPageLoad
		$I->comment("Set base placeholder");
		$I->attachFile("#catalog_placeholder_image_placeholder", "adobe-base.jpg"); // stepKey: uploadBasePlaceholder
		$I->waitForPageLoad(10); // stepKey: uploadBasePlaceholderWaitForPageLoad
		$I->comment("Set small placeholder");
		$I->attachFile("#catalog_placeholder_small_image_placeholder", "adobe-small.jpg"); // stepKey: uploadSmallPlaceholder
		$I->waitForPageLoad(10); // stepKey: uploadSmallPlaceholderWaitForPageLoad
		$I->comment("Set thumbnail placeholder");
		$I->attachFile("#catalog_placeholder_thumbnail_placeholder", "adobe-thumb.jpg"); // stepKey: uploadThumbnailPlaceholder
		$I->waitForPageLoad(10); // stepKey: uploadThumbnailPlaceholderWaitForPageLoad
		$I->comment("Save config with placeholders");
		$I->click("#save"); // stepKey: saveConfigWithPlaceholders
		$I->waitForPageLoad(30); // stepKey: saveConfigWithPlaceholdersWaitForPageLoad
		$I->comment("See images are saved");
		$I->conditionalClick("#catalog_placeholder-head", "#catalog_placeholder_image_placeholder", false); // stepKey: openPlaceholderSection2
		$I->waitForPageLoad(10); // stepKey: openPlaceholderSection2WaitForPageLoad
		$I->waitForElementVisible("#catalog_placeholder_image_placeholder", 30); // stepKey: waitForPlaceholderSectionOpen2
		$I->waitForPageLoad(10); // stepKey: waitForPlaceholderSectionOpen2WaitForPageLoad
		$I->seeElement("#catalog_placeholder_image_placeholder_image[src*='adobe-base']"); // stepKey: seeBasePlaceholderSet
		$I->seeElement("#catalog_placeholder_small_image_placeholder_image[src*='adobe-small']"); // stepKey: seeSmallPlaceholderSet
		$I->seeElement("#catalog_placeholder_thumbnail_placeholder_image[src*='adobe-thumb']"); // stepKey: seeThumbnailPlaceholderSet
		$I->dontSeeElement("#catalog_placeholder_swatch_image_placeholder_image"); // stepKey: dontSeeSwatchImageSet
		$I->comment("See correct placeholder images on category page");
		$I->comment("Check placeholder images on the storefront");
		$I->amOnPage($I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryStorefront1
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontCategory1
		$I->comment("Product with no images uses placeholder");
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('productNoImages', 'name', 'test') . "')]]//img[@class='product-image-photo']"); // stepKey: seeProductNoImagesInCategory
		$getSmallPlaceholderImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('productNoImages', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: getSmallPlaceholderImageSrc
		$I->assertStringContainsString("adobe-small", $getSmallPlaceholderImageSrc); // stepKey: checkSmallPlaceholderImage
		$I->comment("Product with images does not use placeholder");
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('productWithImages', 'name', 'test') . "')]"); // stepKey: seeProductWithImagesInCategory
		$getSmallNonPlaceholderImageSrc = $I->grabAttributeFrom("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('productWithImages', 'name', 'test') . "')]]//img[@class='product-image-photo']", "src"); // stepKey: getSmallNonPlaceholderImageSrc
		$I->assertStringNotContainsString("adobe-small", $getSmallNonPlaceholderImageSrc); // stepKey: checkSmallPlaceholderImageNotUsed
		$I->comment("Check base image on product page");
		$I->comment("Product which is using placeholder");
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('productNoImages', 'name', 'test') . "')]]//img[@class='product-image-photo']"); // stepKey: goToProductNoImages
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad1
		$I->seeInCurrentUrl($I->retrieveEntityField('productNoImages', 'sku', 'test')); // stepKey: seeCorrectProductPage1
		$I->seeElement("//*[@class='product media']//img[contains(@src, 'adobe-base')]"); // stepKey: seeBasePlaceholderImage
		$I->click("button.action.tocart.primary"); // stepKey: addProductToCart1
		$I->waitForPageLoad(30); // stepKey: addProductToCart1WaitForPageLoad
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded1
		$I->waitForPageLoad(30); // stepKey: waitForProductAdded1WaitForPageLoad
		$I->comment("Entering Action Group [openMiniCart1] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageOpenMiniCart1
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart1
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCart1WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart1
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCart1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart1
		$I->comment("Exiting Action Group [openMiniCart1] StorefrontClickOnMiniCartActionGroup");
		$getThumbnailPlaceholderImageSrc = $I->grabAttributeFrom("header ol[id='mini-cart'] span[class='product-image-container'] img[alt='" . $I->retrieveEntityField('productNoImages', 'name', 'test') . "']", "src"); // stepKey: getThumbnailPlaceholderImageSrc
		$I->assertStringContainsString("adobe-thumb", $getThumbnailPlaceholderImageSrc); // stepKey: checkThumbnailPlaceholderImage
		$I->comment("Entering Action Group [removeProductFromCart1] RemoveProductFromMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartRemoveProductFromCart1
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForMiniCartOpenRemoveProductFromCart1
		$I->waitForPageLoad(30); // stepKey: waitForMiniCartOpenRemoveProductFromCart1WaitForPageLoad
		$I->click("//ol[@id='mini-cart']//div[contains(., '" . $I->retrieveEntityField('productNoImages', 'name', 'test') . "')]//a[contains(@class, 'delete')]"); // stepKey: clickDeleteRemoveProductFromCart1
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalRemoveProductFromCart1
		$I->see("Are you sure you would like to remove this item from the shopping cart?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageRemoveProductFromCart1
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteRemoveProductFromCart1
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinishRemoveProductFromCart1
		$I->comment("Exiting Action Group [removeProductFromCart1] RemoveProductFromMiniCartActionGroup");
		$I->comment("Product which is NOT using placeholder");
		$I->amOnPage($I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryStorefront2
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontCategory2
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('productWithImages', 'name', 'test') . "')]]//img[@class='product-image-photo']"); // stepKey: goToProductWithImages
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad2
		$I->seeInCurrentUrl($I->retrieveEntityField('productWithImages', 'sku', 'test')); // stepKey: seeCorrectProductPage2
		$I->dontSeeElement("//*[@class='product media']//img[contains(@src, 'adobe-base')]"); // stepKey: dontSeeBasePlaceholderImage
		$I->click("button.action.tocart.primary"); // stepKey: addProductToCart2
		$I->waitForPageLoad(30); // stepKey: addProductToCart2WaitForPageLoad
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded2
		$I->waitForPageLoad(30); // stepKey: waitForProductAdded2WaitForPageLoad
		$I->comment("Entering Action Group [openMiniCart2] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageOpenMiniCart2
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart2
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCart2WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart2
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCart2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart2
		$I->comment("Exiting Action Group [openMiniCart2] StorefrontClickOnMiniCartActionGroup");
		$getThumbnailImageSrc = $I->grabAttributeFrom("header ol[id='mini-cart'] span[class='product-image-container'] img[alt='" . $I->retrieveEntityField('productWithImages', 'name', 'test') . "']", "src"); // stepKey: getThumbnailImageSrc
		$I->assertStringNotContainsString("adobe-thumb", $getThumbnailImageSrc); // stepKey: checkThumbnailImage
		$I->comment("Entering Action Group [removeProductFromCart2] RemoveProductFromMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartRemoveProductFromCart2
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForMiniCartOpenRemoveProductFromCart2
		$I->waitForPageLoad(30); // stepKey: waitForMiniCartOpenRemoveProductFromCart2WaitForPageLoad
		$I->click("//ol[@id='mini-cart']//div[contains(., '" . $I->retrieveEntityField('productWithImages', 'name', 'test') . "')]//a[contains(@class, 'delete')]"); // stepKey: clickDeleteRemoveProductFromCart2
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalRemoveProductFromCart2
		$I->see("Are you sure you would like to remove this item from the shopping cart?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageRemoveProductFromCart2
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteRemoveProductFromCart2
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinishRemoveProductFromCart2
		$I->comment("Exiting Action Group [removeProductFromCart2] RemoveProductFromMiniCartActionGroup");
	}
}
