<?php
namespace Magento\AcceptanceTest\_RemoteStorageAwsS3EnabledSuite\Backend;

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
 * @Title("MC-38621: S3 - Import and Update Tax Rates")
 * @Description("Imports tax rates from the System > Data Transfer > Import/Export Tax Rates page and             from the Tax Rule page, to create new tax rates and update existing tax rates. Verifies results on the Tax             Rates grid page. Uses S3 for the file system.<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AdminAwsS3ImportTaxRatesTest.xml<br>")
 * @TestCaseId("MC-38621")
 * @group importExport
 * @group tax
 * @group remote_storage_aws_s3
 */
class AdminAwsS3ImportTaxRatesTestCest
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
        $this->helperContainer->create("\Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
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
		$I->comment("BIC workaround");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete/Revert Data");
		$I->comment("Entering Action Group [navigateToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageNavigateToTaxRatesPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageNavigateToTaxRatesPage
		$I->comment("Exiting Action Group [navigateToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->createEntity("revertInitialTaxRateCA", "hook", "US_CA_Rate_1", [], []); // stepKey: revertInitialTaxRateCA
		$I->createEntity("revertInitialTaxRateNY", "hook", "US_NY_Rate_1", [], []); // stepKey: revertInitialTaxRateNY
		$I->comment("Entering Action Group [deleteAllNonDefaultTaxRates] AdminDeleteMultipleTaxRatesActionGroup");
		$I->waitForElementVisible(".admin__data-grid-header [data-action='grid-filter-reset']", 30); // stepKey: waitForResetFilterDeleteAllNonDefaultTaxRates
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickResetFilterDeleteAllNonDefaultTaxRates
		$I->waitForPageLoad(30); // stepKey: waitForGridResetDeleteAllNonDefaultTaxRates
		$I->comment('[deleteAllSpecifiedTaxRulesDeleteAllNonDefaultTaxRates] Magento\Tax\Test\Mftf\Helper\TaxHelpers::deleteAllSpecifiedTaxRuleRows()');
		$this->helperContainer->get('Magento\Tax\Test\Mftf\Helper\TaxHelpers')->deleteAllSpecifiedTaxRuleRows("//table[@id='tax_rate_grid_table']//tbody//tr//td[@data-column='code' and not(contains(.,'US-CA-*-Rate 1')) and not(contains(.,'US-NY-*-Rate 1'))]", "#delete", "aside.confirm .modal-footer button.action-accept", "You deleted the tax rate.", "#messages div.message-success"); // stepKey: deleteAllSpecifiedTaxRulesDeleteAllNonDefaultTaxRates
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteAllNonDefaultTaxRates
		$I->seeNumberOfElements("#tax_rate_grid_table tbody tr", "2"); // stepKey: seeExpectedFinalTotalRowsDeleteAllNonDefaultTaxRates
		$I->comment("Exiting Action Group [deleteAllNonDefaultTaxRates] AdminDeleteMultipleTaxRatesActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->comment("BIC workaround");
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
	 * @Features({"AwsS3"})
	 * @Stories({"Import Tax"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAwsS3ImportTaxRatesTest(AcceptanceTester $I)
	{
		$I->comment("Import Tax Rates from System > Data Transfer");
		$I->comment("Entering Action Group [navigateToImportExportTaxRatesPage] AdminNavigateImportExportTaxRatesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/importExport/"); // stepKey: navigateToImportExportTaxRatesPageNavigateToImportExportTaxRatesPage
		$I->comment("Exiting Action Group [navigateToImportExportTaxRatesPage] AdminNavigateImportExportTaxRatesActionGroup");
		$I->comment("Entering Action Group [importTaxRates] AdminImportTaxRatesActionGroup");
		$I->waitForElementVisible("#import_rates_file", 30); // stepKey: waitForUploadFileImportTaxRates
		$I->attachFile("#import_rates_file", "import_tax_rates.csv"); // stepKey: uploadFileImportTaxRates
		$I->click("[title='Import Tax Rates']"); // stepKey: clickImportTaxRatesImportTaxRates
		$I->waitForPageLoad(30); // stepKey: waitForImportImportTaxRates
		$I->waitForText("The tax rate has been imported.", 30, "#messages div.message-success"); // stepKey: waitForMessageImportTaxRates
		$I->comment("Exiting Action Group [importTaxRates] AdminImportTaxRatesActionGroup");
		$I->comment("Verify Imported Tax Rates");
		$I->comment("Entering Action Group [navigateToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageNavigateToTaxRatesPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageNavigateToTaxRatesPage
		$I->comment("Exiting Action Group [navigateToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [filterGridCA] AdminFilterLegacyGridActionGroup");
		$I->waitForElementVisible(".admin__data-grid-header [data-action='grid-filter-reset']", 30); // stepKey: waitForResetFiltersFilterGridCA
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersFilterGridCA
		$I->waitForPageLoad(30); // stepKey: waitForFilterResetFilterGridCA
		$I->fillField("[data-role='filter-form'] input[name='code']", "US-CA-*-Rate 1"); // stepKey: fillFieldInFilterFilterGridCA
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFilterGridCA
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterGridCA
		$I->comment("Exiting Action Group [filterGridCA] AdminFilterLegacyGridActionGroup");
		$I->comment("Entering Action Group [verifyTaxRateRowCA] AdminAssertTaxRateInGridActionGroup");
		$I->waitForElementVisible("#tax_rate_grid_table tbody tr:nth-of-type(1)", 30); // stepKey: waitForRowVerifyTaxRateRowCA
		$I->waitForPageLoad(30); // stepKey: waitForRowVerifyTaxRateRowCAWaitForPageLoad
		$I->see("US-CA-*-Rate 1", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=code]"); // stepKey: seeTaxIdentifierVerifyTaxRateRowCA
		$I->see("United States", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_country_id]"); // stepKey: seeCountryVerifyTaxRateRowCA
		$I->see("CA", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=region_name]"); // stepKey: seeRegionVerifyTaxRateRowCA
		$I->see("*", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_postcode]"); // stepKey: seeZipVerifyTaxRateRowCA
		$I->see("10.25", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=rate]"); // stepKey: seeRateVerifyTaxRateRowCA
		$I->comment("Exiting Action Group [verifyTaxRateRowCA] AdminAssertTaxRateInGridActionGroup");
		$I->comment("Entering Action Group [filterGridImport1] AdminFilterLegacyGridActionGroup");
		$I->waitForElementVisible(".admin__data-grid-header [data-action='grid-filter-reset']", 30); // stepKey: waitForResetFiltersFilterGridImport1
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersFilterGridImport1
		$I->waitForPageLoad(30); // stepKey: waitForFilterResetFilterGridImport1
		$I->fillField("[data-role='filter-form'] input[name='code']", "import-rate-1"); // stepKey: fillFieldInFilterFilterGridImport1
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFilterGridImport1
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterGridImport1
		$I->comment("Exiting Action Group [filterGridImport1] AdminFilterLegacyGridActionGroup");
		$I->comment("Entering Action Group [verifyTaxRateRowImport1] AdminAssertTaxRateInGridActionGroup");
		$I->waitForElementVisible("#tax_rate_grid_table tbody tr:nth-of-type(1)", 30); // stepKey: waitForRowVerifyTaxRateRowImport1
		$I->waitForPageLoad(30); // stepKey: waitForRowVerifyTaxRateRowImport1WaitForPageLoad
		$I->see("import-rate-1", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=code]"); // stepKey: seeTaxIdentifierVerifyTaxRateRowImport1
		$I->see("United States", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_country_id]"); // stepKey: seeCountryVerifyTaxRateRowImport1
		$I->see("TX", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=region_name]"); // stepKey: seeRegionVerifyTaxRateRowImport1
		$I->see("78758", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_postcode]"); // stepKey: seeZipVerifyTaxRateRowImport1
		$I->see("5.25", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=rate]"); // stepKey: seeRateVerifyTaxRateRowImport1
		$I->comment("Exiting Action Group [verifyTaxRateRowImport1] AdminAssertTaxRateInGridActionGroup");
		$I->comment("Entering Action Group [filterGridImport2] AdminFilterLegacyGridActionGroup");
		$I->waitForElementVisible(".admin__data-grid-header [data-action='grid-filter-reset']", 30); // stepKey: waitForResetFiltersFilterGridImport2
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersFilterGridImport2
		$I->waitForPageLoad(30); // stepKey: waitForFilterResetFilterGridImport2
		$I->fillField("[data-role='filter-form'] input[name='code']", "import-rate-2"); // stepKey: fillFieldInFilterFilterGridImport2
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFilterGridImport2
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterGridImport2
		$I->comment("Exiting Action Group [filterGridImport2] AdminFilterLegacyGridActionGroup");
		$I->comment("Entering Action Group [verifyTaxRateRowImport2] AdminAssertTaxRateInGridActionGroup");
		$I->waitForElementVisible("#tax_rate_grid_table tbody tr:nth-of-type(1)", 30); // stepKey: waitForRowVerifyTaxRateRowImport2
		$I->waitForPageLoad(30); // stepKey: waitForRowVerifyTaxRateRowImport2WaitForPageLoad
		$I->see("import-rate-2", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=code]"); // stepKey: seeTaxIdentifierVerifyTaxRateRowImport2
		$I->see("United States", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_country_id]"); // stepKey: seeCountryVerifyTaxRateRowImport2
		$I->see("AK", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=region_name]"); // stepKey: seeRegionVerifyTaxRateRowImport2
		$I->see("12345-12346", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_postcode]"); // stepKey: seeZipVerifyTaxRateRowImport2
		$I->see("7.75", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=rate]"); // stepKey: seeRateVerifyTaxRateRowImport2
		$I->comment("Exiting Action Group [verifyTaxRateRowImport2] AdminAssertTaxRateInGridActionGroup");
		$I->comment("Delete/Revert Data");
		$I->comment("Entering Action Group [navigateToTaxRatesPage2] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageNavigateToTaxRatesPage2
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageNavigateToTaxRatesPage2
		$I->comment("Exiting Action Group [navigateToTaxRatesPage2] AdminTaxRateGridOpenPageActionGroup");
		$I->createEntity("revertInitialTaxRateCA", "test", "US_CA_Rate_1", [], []); // stepKey: revertInitialTaxRateCA
		$I->createEntity("revertInitialTaxRateNY", "test", "US_NY_Rate_1", [], []); // stepKey: revertInitialTaxRateNY
		$I->comment("Entering Action Group [deleteAllNonDefaultTaxRates] AdminDeleteMultipleTaxRatesActionGroup");
		$I->waitForElementVisible(".admin__data-grid-header [data-action='grid-filter-reset']", 30); // stepKey: waitForResetFilterDeleteAllNonDefaultTaxRates
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickResetFilterDeleteAllNonDefaultTaxRates
		$I->waitForPageLoad(30); // stepKey: waitForGridResetDeleteAllNonDefaultTaxRates
		$I->comment('[deleteAllSpecifiedTaxRulesDeleteAllNonDefaultTaxRates] Magento\Tax\Test\Mftf\Helper\TaxHelpers::deleteAllSpecifiedTaxRuleRows()');
		$this->helperContainer->get('Magento\Tax\Test\Mftf\Helper\TaxHelpers')->deleteAllSpecifiedTaxRuleRows("//table[@id='tax_rate_grid_table']//tbody//tr//td[@data-column='code' and not(contains(.,'US-CA-*-Rate 1')) and not(contains(.,'US-NY-*-Rate 1'))]", "#delete", "aside.confirm .modal-footer button.action-accept", "You deleted the tax rate.", "#messages div.message-success"); // stepKey: deleteAllSpecifiedTaxRulesDeleteAllNonDefaultTaxRates
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteAllNonDefaultTaxRates
		$I->seeNumberOfElements("#tax_rate_grid_table tbody tr", "2"); // stepKey: seeExpectedFinalTotalRowsDeleteAllNonDefaultTaxRates
		$I->comment("Exiting Action Group [deleteAllNonDefaultTaxRates] AdminDeleteMultipleTaxRatesActionGroup");
		$I->comment("Import Tax Rates from Tax Rule Page");
		$I->comment("Entering Action Group [navigateToTaxRulePage] AdminGoToNewTaxRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule/new/"); // stepKey: goToNewTaxRulePageNavigateToTaxRulePage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageNavigateToTaxRulePage
		$I->comment("Exiting Action Group [navigateToTaxRulePage] AdminGoToNewTaxRulePageActionGroup");
		$I->comment("Entering Action Group [importTaxRates2] AdminImportTaxRatesActionGroup");
		$I->waitForElementVisible("#import_rates_file", 30); // stepKey: waitForUploadFileImportTaxRates2
		$I->attachFile("#import_rates_file", "import_tax_rates.csv"); // stepKey: uploadFileImportTaxRates2
		$I->click("[title='Import Tax Rates']"); // stepKey: clickImportTaxRatesImportTaxRates2
		$I->waitForPageLoad(30); // stepKey: waitForImportImportTaxRates2
		$I->waitForText("The tax rate has been imported.", 30, "#messages div.message-success"); // stepKey: waitForMessageImportTaxRates2
		$I->comment("Exiting Action Group [importTaxRates2] AdminImportTaxRatesActionGroup");
		$I->comment("Verify Imported Tax Rates");
		$I->comment("Entering Action Group [navigateToTaxRatesPage3] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageNavigateToTaxRatesPage3
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageNavigateToTaxRatesPage3
		$I->comment("Exiting Action Group [navigateToTaxRatesPage3] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [filterGridCA2] AdminFilterLegacyGridActionGroup");
		$I->waitForElementVisible(".admin__data-grid-header [data-action='grid-filter-reset']", 30); // stepKey: waitForResetFiltersFilterGridCA2
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersFilterGridCA2
		$I->waitForPageLoad(30); // stepKey: waitForFilterResetFilterGridCA2
		$I->fillField("[data-role='filter-form'] input[name='code']", "US-CA-*-Rate 1"); // stepKey: fillFieldInFilterFilterGridCA2
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFilterGridCA2
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterGridCA2
		$I->comment("Exiting Action Group [filterGridCA2] AdminFilterLegacyGridActionGroup");
		$I->comment("Entering Action Group [verifyTaxRateRowCA2] AdminAssertTaxRateInGridActionGroup");
		$I->waitForElementVisible("#tax_rate_grid_table tbody tr:nth-of-type(1)", 30); // stepKey: waitForRowVerifyTaxRateRowCA2
		$I->waitForPageLoad(30); // stepKey: waitForRowVerifyTaxRateRowCA2WaitForPageLoad
		$I->see("US-CA-*-Rate 1", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=code]"); // stepKey: seeTaxIdentifierVerifyTaxRateRowCA2
		$I->see("United States", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_country_id]"); // stepKey: seeCountryVerifyTaxRateRowCA2
		$I->see("CA", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=region_name]"); // stepKey: seeRegionVerifyTaxRateRowCA2
		$I->see("*", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_postcode]"); // stepKey: seeZipVerifyTaxRateRowCA2
		$I->see("10.25", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=rate]"); // stepKey: seeRateVerifyTaxRateRowCA2
		$I->comment("Exiting Action Group [verifyTaxRateRowCA2] AdminAssertTaxRateInGridActionGroup");
		$I->comment("Entering Action Group [filterGridImport3] AdminFilterLegacyGridActionGroup");
		$I->waitForElementVisible(".admin__data-grid-header [data-action='grid-filter-reset']", 30); // stepKey: waitForResetFiltersFilterGridImport3
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersFilterGridImport3
		$I->waitForPageLoad(30); // stepKey: waitForFilterResetFilterGridImport3
		$I->fillField("[data-role='filter-form'] input[name='code']", "import-rate-1"); // stepKey: fillFieldInFilterFilterGridImport3
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFilterGridImport3
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterGridImport3
		$I->comment("Exiting Action Group [filterGridImport3] AdminFilterLegacyGridActionGroup");
		$I->comment("Entering Action Group [verifyTaxRateRowImport3] AdminAssertTaxRateInGridActionGroup");
		$I->waitForElementVisible("#tax_rate_grid_table tbody tr:nth-of-type(1)", 30); // stepKey: waitForRowVerifyTaxRateRowImport3
		$I->waitForPageLoad(30); // stepKey: waitForRowVerifyTaxRateRowImport3WaitForPageLoad
		$I->see("import-rate-1", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=code]"); // stepKey: seeTaxIdentifierVerifyTaxRateRowImport3
		$I->see("United States", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_country_id]"); // stepKey: seeCountryVerifyTaxRateRowImport3
		$I->see("TX", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=region_name]"); // stepKey: seeRegionVerifyTaxRateRowImport3
		$I->see("78758", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_postcode]"); // stepKey: seeZipVerifyTaxRateRowImport3
		$I->see("5.25", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=rate]"); // stepKey: seeRateVerifyTaxRateRowImport3
		$I->comment("Exiting Action Group [verifyTaxRateRowImport3] AdminAssertTaxRateInGridActionGroup");
		$I->comment("Entering Action Group [filterGridImport4] AdminFilterLegacyGridActionGroup");
		$I->waitForElementVisible(".admin__data-grid-header [data-action='grid-filter-reset']", 30); // stepKey: waitForResetFiltersFilterGridImport4
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersFilterGridImport4
		$I->waitForPageLoad(30); // stepKey: waitForFilterResetFilterGridImport4
		$I->fillField("[data-role='filter-form'] input[name='code']", "import-rate-2"); // stepKey: fillFieldInFilterFilterGridImport4
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFilterGridImport4
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterGridImport4
		$I->comment("Exiting Action Group [filterGridImport4] AdminFilterLegacyGridActionGroup");
		$I->comment("Entering Action Group [verifyTaxRateRowImport4] AdminAssertTaxRateInGridActionGroup");
		$I->waitForElementVisible("#tax_rate_grid_table tbody tr:nth-of-type(1)", 30); // stepKey: waitForRowVerifyTaxRateRowImport4
		$I->waitForPageLoad(30); // stepKey: waitForRowVerifyTaxRateRowImport4WaitForPageLoad
		$I->see("import-rate-2", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=code]"); // stepKey: seeTaxIdentifierVerifyTaxRateRowImport4
		$I->see("United States", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_country_id]"); // stepKey: seeCountryVerifyTaxRateRowImport4
		$I->see("AK", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=region_name]"); // stepKey: seeRegionVerifyTaxRateRowImport4
		$I->see("12345-12346", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=tax_postcode]"); // stepKey: seeZipVerifyTaxRateRowImport4
		$I->see("7.75", "#tax_rate_grid_table tbody tr:nth-of-type(1) [data-column=rate]"); // stepKey: seeRateVerifyTaxRateRowImport4
		$I->comment("Exiting Action Group [verifyTaxRateRowImport4] AdminAssertTaxRateInGridActionGroup");
	}
}
