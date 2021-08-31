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
 * @Title("MC-25636: Can't upload Watermark Image")
 * @Description("Watermark images should be able to be uploaded in the admin<h3>Test files</h3>app/code/Magento/Theme/Test/Mftf/Test/AdminWatermarkUploadTest.xml<br>")
 * @TestCaseId("MC-25636")
 * @group Watermark
 */
class AdminWatermarkUploadTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Theme"})
	 * @Stories({"Watermark"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminWatermarkUploadTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/theme/design_config/"); // stepKey: navigateToDesignConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageload1
		$I->click("//*[contains(@class,'data-row')][3]//*[contains(@class,'action-menu-item')]"); // stepKey: editStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageload2
		$I->scrollTo("[data-index='watermark']"); // stepKey: scrollToWatermarkSection
		$I->click("[data-index='watermark']"); // stepKey: openWatermarkSection
		$I->waitForElement("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Base')]]//*[contains(@class,'file-uploader')]//input", 30); // stepKey: waitForInputVisible1
		$I->attachFile("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Base')]]//*[contains(@class,'file-uploader')]//input", "adobe-base.jpg"); // stepKey: attachFile1
		$I->waitForElementVisible("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Base')]]//*[contains(@class,'file-uploader-preview')]//img", 30); // stepKey: waitForPreviewImage
		$I->waitForElement("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Thumbnail')]]//*[contains(@class,'file-uploader')]//input", 30); // stepKey: waitForInputVisible2
		$I->attachFile("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Thumbnail')]]//*[contains(@class,'file-uploader')]//input", "adobe-thumb.jpg"); // stepKey: attachFile2
		$I->waitForElementVisible("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Thumbnail')]]//*[contains(@class,'file-uploader-preview')]//img", 30); // stepKey: waitForPreviewImage2
		$I->waitForElement("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Small')]]//*[contains(@class,'file-uploader')]//input", 30); // stepKey: waitForInputVisible3
		$I->attachFile("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Small')]]//*[contains(@class,'file-uploader')]//input", "adobe-small.jpg"); // stepKey: attachFile3
		$I->waitForElementVisible("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Small')]]//*[contains(@class,'file-uploader-preview')]//img", 30); // stepKey: waitForPreviewImage3
	}
}
