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
 * @Title("MC-42471: Admin validates Vimeo video privacy when getting video information")
 * @Description("Admin should be able to see warning message when adding Vimeo video with restricted privacy privacy when getting video information<h3>Test files</h3>app/code/Magento/ProductVideo/Test/Mftf/Test/AdminValidatePrivacyOnVimeoGetVideoInformationTest.xml<br>")
 * @TestCaseId("MC-42471")
 * @group productVideo
 */
class AdminValidatePrivacyOnVimeoGetVideoInformationTestCest
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
	 * @Stories({"Add/remove images and videos for all product types and category"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminValidatePrivacyOnVimeoGetVideoInformationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewProductPage] AdminOpenNewProductFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: openProductNewPageOpenNewProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenNewProductPage
		$I->comment("Exiting Action Group [openNewProductPage] AdminOpenNewProductFormPageActionGroup");
		$I->comment("Entering Action Group [openAddProductVideoModal] AdminOpenProductVideoModalActionGroup");
		$I->scrollTo("div[data-index=gallery] .admin__collapsible-title", 0, -100); // stepKey: scrollToAreaOpenAddProductVideoModal
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductVideoSectionOpenAddProductVideoModal
		$I->waitForElementVisible("#add_video_button", 30); // stepKey: waitForAddVideoButtonVisibleOpenAddProductVideoModal
		$I->waitForPageLoad(60); // stepKey: waitForAddVideoButtonVisibleOpenAddProductVideoModalWaitForPageLoad
		$I->click("#add_video_button"); // stepKey: addVideoOpenAddProductVideoModal
		$I->waitForPageLoad(60); // stepKey: addVideoOpenAddProductVideoModalWaitForPageLoad
		$I->waitForElementVisible(".modal-slide.mage-new-video-dialog.form-inline._show", 30); // stepKey: waitForUrlElementVisibleslideOpenAddProductVideoModal
		$I->waitForElementVisible("#video_url", 60); // stepKey: waitForUrlElementVisibleOpenAddProductVideoModal
		$I->comment("Exiting Action Group [openAddProductVideoModal] AdminOpenProductVideoModalActionGroup");
		$I->comment("Entering Action Group [fillVideoUrlField] AdminFillProductVideoFieldActionGroup");
		$I->fillField("#video_url", "https://vimeo.com/313826626"); // stepKey: fillVideoFieldFillVideoUrlField
		$I->comment("Exiting Action Group [fillVideoUrlField] AdminFillProductVideoFieldActionGroup");
		$I->comment("Entering Action Group [clickOnGetVideoInformation] AdminGetVideoInformationActionGroup");
		$I->click("#new_video_get"); // stepKey: getVideoInformationClickOnGetVideoInformation
		$I->comment("Exiting Action Group [clickOnGetVideoInformation] AdminGetVideoInformationActionGroup");
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForWarningMessage
		$I->see("Because of its privacy settings, this video cannot be played here.", "aside.confirm .modal-content"); // stepKey: seeAdminWarningMessage
	}
}
