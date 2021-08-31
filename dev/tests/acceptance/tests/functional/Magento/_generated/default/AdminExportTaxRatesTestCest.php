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
 * @Title("MC-38621: Export Tax Rates")
 * @Description("Exports tax rates from the System > Data Transfer > Import/Export Tax Rates page, from             the Tax Rule page, from the Tax Rates grid page as a .csv, and from the Tax Rates grid page as an .xml.             Validates contents in downloaded file for each export area. Note that MFTF cannot simply click export and             have access to the file that is downloaded in the browser due to the test not having access to the server             that is running the test browser. Therefore, this test verifies that the Export button can be successfully             clicked, grabs the request URL from the Export button's form, executes the request on the magento machine             via a curl request, and verifies the contents of the exported file.<h3>Test files</h3>app/code/Magento/TaxImportExport/Test/Mftf/Test/AdminExportTaxRatesTest.xml<br>")
 * @TestCaseId("MC-38621")
 * @group importExport
 * @group tax
 */
class AdminExportTaxRatesTestCest
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
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create/Revert Seed Data");
		$I->createEntity("revertInitialTaxRateCA", "hook", "US_CA_Rate_1", [], []); // stepKey: revertInitialTaxRateCA
		$I->createEntity("revertInitialTaxRateNY", "hook", "US_NY_Rate_1", [], []); // stepKey: revertInitialTaxRateNY
		$I->comment("Login as Admin");
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
		$I->comment("Logout");
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
	 * @Features({"TaxImportExport"})
	 * @Stories({"Export"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminExportTaxRatesTest(AcceptanceTester $I)
	{
		$I->comment("Export Tax Rates & Validate Export from System > Data Transfer");
		$I->comment("Entering Action Group [navigateToImportExportTaxRatesPage] AdminNavigateImportExportTaxRatesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/importExport/"); // stepKey: navigateToImportExportTaxRatesPageNavigateToImportExportTaxRatesPage
		$I->comment("Exiting Action Group [navigateToImportExportTaxRatesPage] AdminNavigateImportExportTaxRatesActionGroup");
		$I->comment("Entering Action Group [exportTaxRates] AdminClickExportTaxRatesActionGroup");
		$I->waitForElementVisible("#export_form [title='Export Tax Rates']", 30); // stepKey: waitForExportTaxRatesExportTaxRates
		$I->click("#export_form [title='Export Tax Rates']"); // stepKey: clickExportTaxRatesExportTaxRates
		$I->waitForPageLoad(30); // stepKey: waitForExportExportTaxRates
		$I->comment("Exiting Action Group [exportTaxRates] AdminClickExportTaxRatesActionGroup");
		$grabExportUrl = $I->grabAttributeFrom("#export_form", "action"); // stepKey: grabExportUrl
		$grabFormKey = $I->executeJS("return window.FORM_KEY"); // stepKey: grabFormKey
		$I->comment('[assertExportedFileContainsCATaxRate] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "US-CA-*-Rate 1", "{\"form_key\": \"{$grabFormKey}\"}", 'admin', ''); // stepKey: assertExportedFileContainsCATaxRate
		$I->comment('[assertExportedFileContainsNYTaxRate] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl, "US-NY-*-Rate 1", "{\"form_key\": \"{$grabFormKey}\"}", 'admin', ''); // stepKey: assertExportedFileContainsNYTaxRate
		$I->comment("Export Tax Rates & Validate Export from Tax Rule Page");
		$I->comment("Entering Action Group [navigateToTaxRulePage] AdminGoToNewTaxRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule/new/"); // stepKey: goToNewTaxRulePageNavigateToTaxRulePage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageNavigateToTaxRulePage
		$I->comment("Exiting Action Group [navigateToTaxRulePage] AdminGoToNewTaxRulePageActionGroup");
		$I->comment("Entering Action Group [exportTaxRates2] AdminClickExportTaxRatesActionGroup");
		$I->waitForElementVisible("#export_form [title='Export Tax Rates']", 30); // stepKey: waitForExportTaxRatesExportTaxRates2
		$I->click("#export_form [title='Export Tax Rates']"); // stepKey: clickExportTaxRatesExportTaxRates2
		$I->waitForPageLoad(30); // stepKey: waitForExportExportTaxRates2
		$I->comment("Exiting Action Group [exportTaxRates2] AdminClickExportTaxRatesActionGroup");
		$grabExportUrl2 = $I->grabAttributeFrom("#export_form", "action"); // stepKey: grabExportUrl2
		$grabFormKey2 = $I->executeJS("return window.FORM_KEY"); // stepKey: grabFormKey2
		$I->comment('[assertExportedFileContainsCATaxRate2] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl2, "US-CA-*-Rate 1", "{\"form_key\": \"{$grabFormKey2}\"}", 'admin', ''); // stepKey: assertExportedFileContainsCATaxRate2
		$I->comment('[assertExportedFileContainsNYTaxRate2] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl2, "US-NY-*-Rate 1", "{\"form_key\": \"{$grabFormKey2}\"}", 'admin', ''); // stepKey: assertExportedFileContainsNYTaxRate2
		$I->comment("Export Tax Rates & Validate Export from Tax Rates Grid Page as CSV");
		$I->comment("Entering Action Group [navigateToTaxRatesGridPage] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageNavigateToTaxRatesGridPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageNavigateToTaxRatesGridPage
		$I->comment("Exiting Action Group [navigateToTaxRatesGridPage] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [exportTaxRatesCSV] AdminExportTaxRatesFromGridActionGroup");
		$I->waitForElementVisible("#tax_rate_grid_export", 30); // stepKey: waitForExportFileTypeDropDownExportTaxRatesCSV
		$I->selectOption("#tax_rate_grid_export", "CSV"); // stepKey: selectFileTypeExportTaxRatesCSV
		$I->click("#tax_rate_grid [title='Export']"); // stepKey: clickExportButtonExportTaxRatesCSV
		$I->waitForPageLoad(30); // stepKey: waitForExportExportTaxRatesCSV
		$I->comment("Exiting Action Group [exportTaxRatesCSV] AdminExportTaxRatesFromGridActionGroup");
		$grabExportUrl3 = $I->grabAttributeFrom("//select[@id='tax_rate_grid_export']//option[.='CSV']", "value"); // stepKey: grabExportUrl3
		$grabFormKey3 = $I->executeJS("return window.FORM_KEY"); // stepKey: grabFormKey3
		$I->comment('[assertExportedFileContainsCATaxRate3] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl3, "US-CA-*-Rate 1", "{\"form_key\": \"{$grabFormKey3}\"}", 'admin', ''); // stepKey: assertExportedFileContainsCATaxRate3
		$I->comment('[assertExportedFileContainsNYTaxRate3] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl3, "US-NY-*-Rate 1", "{\"form_key\": \"{$grabFormKey3}\"}", 'admin', ''); // stepKey: assertExportedFileContainsNYTaxRate3
		$I->comment("Export Tax Rates & Validate Export from Tax Rates Grid Page as XML");
		$I->comment("Entering Action Group [exportTaxRatesXML] AdminExportTaxRatesFromGridActionGroup");
		$I->waitForElementVisible("#tax_rate_grid_export", 30); // stepKey: waitForExportFileTypeDropDownExportTaxRatesXML
		$I->selectOption("#tax_rate_grid_export", "Excel XML"); // stepKey: selectFileTypeExportTaxRatesXML
		$I->click("#tax_rate_grid [title='Export']"); // stepKey: clickExportButtonExportTaxRatesXML
		$I->waitForPageLoad(30); // stepKey: waitForExportExportTaxRatesXML
		$I->comment("Exiting Action Group [exportTaxRatesXML] AdminExportTaxRatesFromGridActionGroup");
		$grabExportUrl4 = $I->grabAttributeFrom("//select[@id='tax_rate_grid_export']//option[.='Excel XML']", "value"); // stepKey: grabExportUrl4
		$grabFormKey4 = $I->executeJS("return window.FORM_KEY"); // stepKey: grabFormKey4
		$I->comment('[assertExportedFileContainsCATaxRate4] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl4, "US-CA-*-Rate 1", "{\"form_key\": \"{$grabFormKey4}\"}", 'admin', ''); // stepKey: assertExportedFileContainsCATaxRate4
		$I->comment('[assertExportedFileContainsNYTaxRate4] Magento\Backend\Test\Mftf\Helper\CurlHelpers::assertCurlResponseContainsString()');
		$this->helperContainer->get('Magento\Backend\Test\Mftf\Helper\CurlHelpers')->assertCurlResponseContainsString($grabExportUrl4, "US-NY-*-Rate 1", "{\"form_key\": \"{$grabFormKey4}\"}", 'admin', ''); // stepKey: assertExportedFileContainsNYTaxRate4
	}
}
