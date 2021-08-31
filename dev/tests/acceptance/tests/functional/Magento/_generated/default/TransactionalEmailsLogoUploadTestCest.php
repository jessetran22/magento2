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
 * @Title("MC-27620: Uploading a Transactional Emails logo")
 * @Description("Transactional Emails Logo should be able to be uploaded in the admin and previewed<h3>Test files</h3>app/code/Magento/Email/Test/Mftf/Test/TransactionalEmailsLogoUploadTest.xml<br>")
 * @TestCaseId("MC-27620")
 * @group theme
 * @group email
 */
class TransactionalEmailsLogoUploadTestCest
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
		$I->comment("Login to Admin Area");
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
		$I->comment("Clear filter on Design Config Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/theme/design_config/"); // stepKey: navigateToDesignConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadToViewDesignConfigPage
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Logout from Admin Area");
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
	 * @Features({"Email"})
	 * @Stories({"Transactional Emails logo"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function TransactionalEmailsLogoUploadTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to content->Design->Config page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/theme/design_config/"); // stepKey: navigateToDesignConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadToViewDesignConfigPage
		$I->comment("Entering Action Group [filterThemeDesignConfiguration] AdminGridFilterSearchResultsBySelectActionGroup");
		$I->conditionalClick("(//*[contains(@class, 'admin__data-grid-header')][contains(@data-bind, 'afterRender: \$data.setToolbarNode')]//button[contains(@data-action, 'reset')])[1]", "(//*[contains(@class, 'admin__data-grid-header')][contains(@data-bind, 'afterRender: \$data.setToolbarNode')]//button[contains(@data-action, 'reset')])[1]", true); // stepKey: clearTheFiltersIfPresentFilterThemeDesignConfiguration
		$I->waitForPageLoad(5); // stepKey: clearTheFiltersIfPresentFilterThemeDesignConfigurationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterAppliedFilterThemeDesignConfiguration
		$I->click(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersFilterThemeDesignConfiguration
		$I->waitForPageLoad(5); // stepKey: clickOnFiltersFilterThemeDesignConfigurationWaitForPageLoad
		$I->selectOption("//*[@data-part='filter-form']//select[@name='store_id']", "Default Store View"); // stepKey: setAttributeValueFilterThemeDesignConfiguration
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOnApplyFiltersFilterThemeDesignConfiguration
		$I->waitForPageLoad(30); // stepKey: clickOnApplyFiltersFilterThemeDesignConfigurationWaitForPageLoad
		$I->comment("Exiting Action Group [filterThemeDesignConfiguration] AdminGridFilterSearchResultsBySelectActionGroup");
		$I->click("//*[contains(@class,'data-row')][1]//*[contains(@class,'action-menu-item')]"); // stepKey: editStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadToOpenStoreViewEditPage
		$I->comment("Upload Image");
		$I->comment("Entering Action Group [uploadImage] AdminUploadTransactionEmailsImageActionGroup");
		$I->conditionalClick("[data-index='email'] .fieldset-wrapper-title", "[data-index='email'] .admin__fieldset-wrapper-content", false); // stepKey: openTransactionalEmailSectionUploadImage
		$I->waitForPageLoad(30); // stepKey: openTransactionalEmailSectionUploadImageWaitForPageLoad
		$I->waitForElementVisible("[name='email_logo_alt']", 30); // stepKey: waitVisibleUploadLogoUploadImage
		$I->attachFile("[name='email_logo']", "magento-logo.png"); // stepKey: attachLogoUploadImage
		$I->waitForElementVisible("[alt ='magento-logo.png']", 30); // stepKey: waitingForLogoToUploadUploadImage
		$I->seeElement("[alt ='magento-logo.png']"); // stepKey: logoPreviewIsVisibleUploadImage
		$I->fillField("[name='email_logo_alt']", "magento-logo.png"); // stepKey: fillFieldImageAltUploadImage
		$I->fillField("[name='email_logo_width']", "200"); // stepKey: fillFieldImageWidthUploadImage
		$I->fillField("[name='email_logo_height']", "100"); // stepKey: fillFieldImageHeightUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminUploadTransactionEmailsImageActionGroup");
		$I->comment("Save Design Configuration");
		$I->comment("Entering Action Group [saveDesignConfiguration] ClickSaveButtonActionGroup");
		$I->click("#save"); // stepKey: clickSaveSaveDesignConfiguration
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveDesignConfigurationWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitMessageSaveDesignConfiguration
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: verifyMessageSaveDesignConfiguration
		$I->comment("Exiting Action Group [saveDesignConfiguration] ClickSaveButtonActionGroup");
	}
}
