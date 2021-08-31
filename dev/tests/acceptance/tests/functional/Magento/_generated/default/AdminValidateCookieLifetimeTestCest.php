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
 * @Title("[NO TESTCASEID]: Admin should not able to enter text in cookie lifetime filed")
 * @Description("Admin can only be able type numbers in cookie lifetime filed in Magento admin<h3>Test files</h3>app/code/Magento/Cookie/Test/Mftf/Test/AdminValidateCookieLifetimeTest.xml<br>")
 * @group Cookie
 */
class AdminValidateCookieLifetimeTestCest
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
		$I->comment("Entering Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginGetFromGeneralFile
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginGetFromGeneralFile
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginGetFromGeneralFile
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginGetFromGeneralFile
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginGetFromGeneralFileWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginGetFromGeneralFile
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginGetFromGeneralFile
		$I->comment("Exiting Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Cookie"})
	 * @Stories({"Validate cookie lifetime field in Magento admin"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminValidateCookieLifetimeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToDefaultCookieSettingsPage] AdminNavigateToDefaultCookieSettingsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToDefaultCookieSettingsNavigateToDefaultCookieSettingsPage
		$I->waitForPageLoad(30); // stepKey: waitForWebConfigurationPageLoadNavigateToDefaultCookieSettingsPage
		$I->scrollTo("#web_cookie-head", -150, -150); // stepKey: scrollToDefaultCookieSettingsSectionNavigateToDefaultCookieSettingsPage
		$I->conditionalClick("#web_cookie-head", "#web_cookie_cookie_lifetime", false); // stepKey: expandDefaultCookieSettingsTabNavigateToDefaultCookieSettingsPage
		$I->waitForElementVisible("#web_cookie-head", 30); // stepKey: waitForElementsAppearedNavigateToDefaultCookieSettingsPage
		$I->comment("Exiting Action Group [navigateToDefaultCookieSettingsPage] AdminNavigateToDefaultCookieSettingsActionGroup");
		$I->comment("Entering Action Group [uncheckUseSystemValue] AdminUncheckUseSystemValueActionGroup");
		$I->uncheckOption("#row_web_cookie_cookie_lifetime > .use-default > input"); // stepKey: uncheckUseSystemValueUncheckUseSystemValue
		$I->uncheckOption("#row_web_cookie_cookie_lifetime > .use-default > input"); // stepKey: uncheckCheckboxUncheckUseSystemValue
		$I->comment("Exiting Action Group [uncheckUseSystemValue] AdminUncheckUseSystemValueActionGroup");
		$I->comment("Entering Action Group [fillCookieLifetimeField] AdminFillCookieLifetimeActionGroup");
		$I->fillField("#web_cookie_cookie_lifetime", "cookie"); // stepKey: fillFieldCookieLifetimeFillCookieLifetimeField
		$I->comment("Exiting Action Group [fillCookieLifetimeField] AdminFillCookieLifetimeActionGroup");
		$I->comment("Entering Action Group [clickSaveButtonWithString] AdminClickFormActionButtonActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForButtonClickSaveButtonWithString
		$I->waitForPageLoad(30); // stepKey: waitForButtonClickSaveButtonWithStringWaitForPageLoad
		$I->click("#save"); // stepKey: clickButtonClickSaveButtonWithString
		$I->waitForPageLoad(30); // stepKey: clickButtonClickSaveButtonWithStringWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickSaveButtonWithString
		$I->comment("Exiting Action Group [clickSaveButtonWithString] AdminClickFormActionButtonActionGroup");
		$I->comment("Entering Action Group [assertNumberValidation] AssertAdminValidationErrorActionGroup");
		$I->see("Please enter a valid number in this field.", "#web_cookie_cookie_lifetime-error"); // stepKey: seeElementValidationErrorAssertNumberValidation
		$I->comment("Exiting Action Group [assertNumberValidation] AssertAdminValidationErrorActionGroup");
		$I->comment("Entering Action Group [fillCookieLifetimeFieldWithNumber] AdminFillCookieLifetimeActionGroup");
		$I->fillField("#web_cookie_cookie_lifetime", "3600"); // stepKey: fillFieldCookieLifetimeFillCookieLifetimeFieldWithNumber
		$I->comment("Exiting Action Group [fillCookieLifetimeFieldWithNumber] AdminFillCookieLifetimeActionGroup");
		$I->comment("Entering Action Group [checkUseSystemValue] AdminCheckUseSystemValueActionGroup");
		$I->checkOption("#row_web_cookie_cookie_lifetime > .use-default > input"); // stepKey: checkUseSystemValueCheckUseSystemValue
		$I->comment("Exiting Action Group [checkUseSystemValue] AdminCheckUseSystemValueActionGroup");
		$I->comment("Entering Action Group [clickSaveButtonWithNumber] AdminClickFormActionButtonActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForButtonClickSaveButtonWithNumber
		$I->waitForPageLoad(30); // stepKey: waitForButtonClickSaveButtonWithNumberWaitForPageLoad
		$I->click("#save"); // stepKey: clickButtonClickSaveButtonWithNumber
		$I->waitForPageLoad(30); // stepKey: clickButtonClickSaveButtonWithNumberWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickSaveButtonWithNumber
		$I->comment("Exiting Action Group [clickSaveButtonWithNumber] AdminClickFormActionButtonActionGroup");
		$I->comment("Entering Action Group [assertSaveCookieLifetimeSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSaveCookieLifetimeSuccessMessage
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: verifyMessageAssertSaveCookieLifetimeSuccessMessage
		$I->comment("Exiting Action Group [assertSaveCookieLifetimeSuccessMessage] AssertMessageInAdminPanelActionGroup");
	}
}
