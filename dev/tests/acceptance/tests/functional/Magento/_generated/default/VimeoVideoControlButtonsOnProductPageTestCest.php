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
 * @Title("MC-40398: Navigation arrow buttons not visible after video starts on product image")
 * @Description("Navigation arrow buttons not visible after video starts on product image<h3>Test files</h3>app/code/Magento/ProductVideo/Test/Mftf/Test/VimeoVideoControlButtonsOnProductPageTest.xml<br>")
 * @TestCaseId("MC-40398")
 * @group productVideo
 */
class VimeoVideoControlButtonsOnProductPageTestCest
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
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Login to Admin page");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Logout from Admin page");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"ProductVideo"})
	 * @Stories({"Navigation arrow buttons not visible after video starts on product image"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VimeoVideoControlButtonsOnProductPageTest(AcceptanceTester $I)
	{
		$I->comment("Open product edit page");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Add image to product");
		$I->comment("Entering Action Group [addImageForProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageForProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageForProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageForProduct
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddImageForProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageForProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageForProduct
		$I->comment("Exiting Action Group [addImageForProduct] AddProductImageActionGroup");
		$I->comment("Add product video");
		$I->comment("Entering Action Group [addProductVideo] AddProductVideoActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAddProductVideo
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAddProductVideo
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleAddProductVideo
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleAddProductVideoWaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoAddProductVideo
		$I->waitForPageLoad(60); // stepKey: addVideoAddProductVideoWaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideAddProductVideo
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleAddProductVideo
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlAddProductVideo
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleAddProductVideo
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductVideo
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleAddProductVideo
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoAddProductVideo
		$I->waitForPageLoad(30); // stepKey: saveVideoAddProductVideoWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddProductVideo
		$I->comment("Exiting Action Group [addProductVideo] AddProductVideoActionGroup");
		$I->comment("Save product form");
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Open storefront product page");
		$I->comment("Entering Action Group [goToStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageGoToStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedGoToStorefrontProductPage
		$I->comment("Exiting Action Group [goToStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Check the navigation arrows on Storefront Product page");
		$I->comment("Entering Action Group [assertProductVideoNavigationArrowsOnStorefrontProductPage] AssertProductVideoNavigationArrowsActionGroup");
		$I->dontSeeElement(".product.media .fotorama-item .fotorama__wrap--toggle-arrows .fotorama__arr--prev"); // stepKey: dontSeePrevButtonAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: dontSeePrevButtonAssertProductVideoNavigationArrowsOnStorefrontProductPageWaitForPageLoad
		$I->moveMouseOver("//*[contains(@class,'fotorama__stage__shaft')]"); // stepKey: hoverOverImageAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForElementVisible(".product.media .fotorama-item .fotorama__wrap--toggle-arrows .fotorama__arr--next", 30); // stepKey: seeNextButtonAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: seeNextButtonAssertProductVideoNavigationArrowsOnStorefrontProductPageWaitForPageLoad
		$I->click(".product.media .fotorama-item .fotorama__wrap--toggle-arrows .fotorama__arr--next"); // stepKey: clickNextButtonAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: clickNextButtonAssertProductVideoNavigationArrowsOnStorefrontProductPageWaitForPageLoad
		$I->waitForElementVisible("//*[@class='product-video' and @data-type='vimeo']", 30); // stepKey: seeProductVideoDataTypeAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->dontSeeElement("//*[@class='fotorama__video-close fotorama-show-control']"); // stepKey: dontSeeCloseVideoAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->click("//*[contains(@class,'fotorama__stage__shaft')]"); // stepKey: clickToPlayVideoAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->wait(5); // stepKey: waitFiveSecondsToPlayVideoAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->dontSeeElement(".product.media .fotorama-item .fotorama__wrap--toggle-arrows .fotorama__arr--prev"); // stepKey: dontSeePrevButtonSecondAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: dontSeePrevButtonSecondAssertProductVideoNavigationArrowsOnStorefrontProductPageWaitForPageLoad
		$I->dontSeeElement(".product.media .fotorama-item .fotorama__wrap--toggle-arrows .fotorama__arr--next"); // stepKey: dontSeeNextButtonAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: dontSeeNextButtonAssertProductVideoNavigationArrowsOnStorefrontProductPageWaitForPageLoad
		$I->seeElement("//*[@class='fotorama__video-close fotorama-show-control']"); // stepKey: seeCloseVideoAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->click("//*[@class='fotorama__video-close fotorama-show-control']"); // stepKey: clickToCloseVideoAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->wait(2); // stepKey: waitTwoSecondsToCloseVideoAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->dontSeeElementInDOM(".fotorama__wrap.fotorama__wrap--no-controls"); // stepKey: videoFocusedAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->moveMouseOver("#maincontent .page-title"); // stepKey: unFocusVideoAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForElement(".fotorama__wrap.fotorama__wrap--no-controls", 30); // stepKey: waitForVideoUnFocusAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->moveMouseOver("//*[contains(@class,'fotorama__stage__shaft')]"); // stepKey: hoverOverImageSecondAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForElementVisible(".product.media .fotorama-item .fotorama__wrap--toggle-arrows .fotorama__arr--prev", 30); // stepKey: seePrevButtonAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: seePrevButtonAssertProductVideoNavigationArrowsOnStorefrontProductPageWaitForPageLoad
		$I->click(".product.media .fotorama-item .fotorama__wrap--toggle-arrows .fotorama__arr--prev"); // stepKey: clickPrevButtonAssertProductVideoNavigationArrowsOnStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: clickPrevButtonAssertProductVideoNavigationArrowsOnStorefrontProductPageWaitForPageLoad
		$I->comment("Exiting Action Group [assertProductVideoNavigationArrowsOnStorefrontProductPage] AssertProductVideoNavigationArrowsActionGroup");
	}
}
