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
 * @Title("MC-42645: Admin should be able to upload same Vimeo video for multiple products")
 * @Description("Admin should be able to upload same Vimeo video for multiple products<h3>Test files</h3>app/code/Magento/ProductVideo/Test/Mftf/Test/AdminUploadSameVimeoVideoForMultipleProductsTest.xml<br>")
 * @TestCaseId("MC-42645")
 * @group productVideo
 */
class AdminUploadSameVimeoVideoForMultipleProductsTestCest
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
		$I->createEntity("setYoutubeApiKeyConfig", "hook", "ProductVideoYoutubeApiKeyConfig", [], []); // stepKey: setYoutubeApiKeyConfig
		$I->createEntity("createProduct1", "hook", "SimpleProduct2", [], []); // stepKey: createProduct1
		$I->createEntity("createProduct2", "hook", "SimpleProduct2", [], []); // stepKey: createProduct2
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
		$I->createEntity("setYoutubeApiKeyDefaultConfig", "hook", "DefaultProductVideoConfig", [], []); // stepKey: setYoutubeApiKeyDefaultConfig
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteProduct2
		$I->comment("Logout from Admin page");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"Upload product video"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUploadSameVimeoVideoForMultipleProductsTest(AcceptanceTester $I)
	{
		$I->comment("Open product 1 edit page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct1', 'id', 'test')); // stepKey: goToProduct1EditPage
		$I->comment("Add product video");
		$I->comment("Entering Action Group [addProductVideoToProduct1] AddProductVideoActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaAddProductVideoToProduct1
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionAddProductVideoToProduct1
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleAddProductVideoToProduct1
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleAddProductVideoToProduct1WaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoAddProductVideoToProduct1
		$I->waitForPageLoad(60); // stepKey: addVideoAddProductVideoToProduct1WaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideAddProductVideoToProduct1
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleAddProductVideoToProduct1
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlAddProductVideoToProduct1
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleAddProductVideoToProduct1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductVideoToProduct1
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleAddProductVideoToProduct1
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoAddProductVideoToProduct1
		$I->waitForPageLoad(30); // stepKey: saveVideoAddProductVideoToProduct1WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddProductVideoToProduct1
		$I->comment("Exiting Action Group [addProductVideoToProduct1] AddProductVideoActionGroup");
		$I->comment("Save product form");
		$I->comment("Entering Action Group [saveProductFormOfProduct1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductFormOfProduct1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductFormOfProduct1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormOfProduct1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductFormOfProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormOfProduct1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductFormOfProduct1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductFormOfProduct1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductFormOfProduct1
		$I->comment("Exiting Action Group [saveProductFormOfProduct1] SaveProductFormActionGroup");
		$I->comment("Open product 2 edit page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct2', 'id', 'test')); // stepKey: goToProduct2EditPage
		$I->comment("Add product video");
		$I->comment("Entering Action Group [saveProductFormOfProduct2] AddProductVideoActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaSaveProductFormOfProduct2
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionSaveProductFormOfProduct2
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleSaveProductFormOfProduct2
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleSaveProductFormOfProduct2WaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoSaveProductFormOfProduct2
		$I->waitForPageLoad(60); // stepKey: addVideoSaveProductFormOfProduct2WaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideSaveProductFormOfProduct2
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleSaveProductFormOfProduct2
		$I->fillField("#video_url", "https://vimeo.com/76979871"); // stepKey: fillFieldVideoUrlSaveProductFormOfProduct2
		$I->fillField("#video_title", "The New Vimeo Player (You Know, For Videos)"); // stepKey: fillFieldVideoTitleSaveProductFormOfProduct2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSaveProductFormOfProduct2
		$I->waitForElementNotVisible("//button[@class='action-primary video-create-button' and @disabled='disabled']", 30); // stepKey: waitForSaveButtonVisibleSaveProductFormOfProduct2
		$I->click(".action-primary.video-create-button"); // stepKey: saveVideoSaveProductFormOfProduct2
		$I->waitForPageLoad(30); // stepKey: saveVideoSaveProductFormOfProduct2WaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearSaveProductFormOfProduct2
		$I->comment("Exiting Action Group [saveProductFormOfProduct2] AddProductVideoActionGroup");
		$I->comment("Save product form");
		$I->comment("Entering Action Group [saveProductFormOfSecondSimpleProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductFormOfSecondSimpleProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductFormOfSecondSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormOfSecondSimpleProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductFormOfSecondSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormOfSecondSimpleProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductFormOfSecondSimpleProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductFormOfSecondSimpleProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductFormOfSecondSimpleProduct
		$I->comment("Exiting Action Group [saveProductFormOfSecondSimpleProduct] SaveProductFormActionGroup");
	}
}
