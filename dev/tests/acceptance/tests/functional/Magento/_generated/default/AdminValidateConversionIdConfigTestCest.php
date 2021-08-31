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
 * @Title("[NO TESTCASEID]: Admin validates the conversion ID when configuring the Google Adwords")
 * @Description("Testing for a required Conversion ID when configuring the Google Adwords<h3>Test files</h3>app/code/Magento/GoogleAdwords/Test/Mftf/Test/AdminValidateConversionIdConfigTest.xml<br>")
 */
class AdminValidateConversionIdConfigTestCest
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
	 * @Stories({"Admin validates the conversion ID when configuring the Google Adwords"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Features({"GoogleAdwords"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminValidateConversionIdConfigTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToConfigPage] AdminNavigateToGoogleAdwordsConfigurationActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/google/"); // stepKey: navigateToConfigurationPageGoToConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToConfigPage
		$I->comment("Exiting Action Group [goToConfigPage] AdminNavigateToGoogleAdwordsConfigurationActionGroup");
		$I->comment("Entering Action Group [expandingGoogleAdwordsSection] AdminExpandConfigSectionActionGroup");
		$I->conditionalClick("//form[@id='config-edit-form']//div[@class='section-config'][contains(.,'Google AdWords')]", "//form[@id='config-edit-form']//div[@class='section-config active'][contains(.,'Google AdWords')]", false); // stepKey: expandSectionExpandingGoogleAdwordsSection
		$I->waitForElement("//form[@id='config-edit-form']//div[@class='section-config active'][contains(.,'Google AdWords')]", 30); // stepKey: waitOpenedSectionExpandingGoogleAdwordsSection
		$I->comment("Exiting Action Group [expandingGoogleAdwordsSection] AdminExpandConfigSectionActionGroup");
		$I->comment("Entering Action Group [uncheckUseSystemValue] AdminUncheckUseSystemValueActionGroup");
		$I->uncheckOption("#row_google_adwords_active > .use-default > input"); // stepKey: uncheckUseSystemValueUncheckUseSystemValue
		$I->uncheckOption("#row_google_adwords_active > .use-default > input"); // stepKey: uncheckCheckboxUncheckUseSystemValue
		$I->comment("Exiting Action Group [uncheckUseSystemValue] AdminUncheckUseSystemValueActionGroup");
		$I->comment("Entering Action Group [enableGoogleAdwordsConfig] AdminToggleEnabledActionGroup");
		$I->selectOption("#google_adwords_active", "Yes"); // stepKey: switchActiveStateEnableGoogleAdwordsConfig
		$I->comment("Exiting Action Group [enableGoogleAdwordsConfig] AdminToggleEnabledActionGroup");
		$I->comment("Entering Action Group [clickSaveCustomVariable] AdminClickFormActionButtonActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForButtonClickSaveCustomVariable
		$I->waitForPageLoad(30); // stepKey: waitForButtonClickSaveCustomVariableWaitForPageLoad
		$I->click("#save"); // stepKey: clickButtonClickSaveCustomVariable
		$I->waitForPageLoad(30); // stepKey: clickButtonClickSaveCustomVariableWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickSaveCustomVariable
		$I->comment("Exiting Action Group [clickSaveCustomVariable] AdminClickFormActionButtonActionGroup");
		$I->comment("Entering Action Group [seeRequiredValidationErrorForConversionId] AssertAdminValidationErrorActionGroup");
		$I->see("This is a required field.", "#google_adwords_conversion_id-error"); // stepKey: seeElementValidationErrorSeeRequiredValidationErrorForConversionId
		$I->comment("Exiting Action Group [seeRequiredValidationErrorForConversionId] AssertAdminValidationErrorActionGroup");
	}
}
