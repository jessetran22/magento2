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
 * @Title("MC-5330: Update tax rate, large rate")
 * @Description("Test log in to Tax Rate and Update Large Rate<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/UpdateLargeTaxRateEntityTest.xml<br>")
 * @TestCaseId("MC-5330")
 * @group tax
 * @group mtf_migrated
 */
class UpdateLargeTaxRateEntityTestCest
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
		$I->createEntity("initialTaxRate", "hook", "defaultTaxRate", [], []); // stepKey: initialTaxRate
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
		$I->deleteEntity("initialTaxRate", "hook"); // stepKey: deleteTaxRate
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
	 * @Stories({"Update Tax Rate"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Tax"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function UpdateLargeTaxRateEntityTest(AcceptanceTester $I)
	{
		$I->comment("Search the tax rate on tax grid page");
		$I->comment("Entering Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex1
		$I->comment("Exiting Action Group [goToTaxRateIndex1] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters1
		$I->comment("Exiting Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->comment("Entering Action Group [fillCode] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->fillField("#tax_rate_grid_filter_code", $I->retrieveEntityField('initialTaxRate', 'code', 'test')); // stepKey: fillNameFilterFillCode
		$I->comment("Exiting Action Group [fillCode] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch1
		$I->waitForPageLoad(30); // stepKey: clickSearch1WaitForPageLoad
		$I->click("#tax_rate_grid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRow1
		$I->waitForPageLoad(30); // stepKey: clickFirstRow1WaitForPageLoad
		$I->comment("Update large tax rate on the tax rate form page");
		$I->fillField("#code", "TaxRate" . msq("defaultTaxRateWithLargeRate")); // stepKey: fillTaxIdentifierField2
		$I->selectOption("#tax_country_id", "GB"); // stepKey: selectCountry1
		$I->fillField("#tax_postcode", "*"); // stepKey: fillPostCode
		$I->fillField("#rate", "777.0000"); // stepKey: fillRate1
		$I->click("#save"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->see("You saved the tax rate.", "#messages div.message-success"); // stepKey: seeSuccess
		$I->comment("Verify we see updated large tax rate(from the above step) on the tax rate grid page");
		$I->comment("Entering Action Group [goToTaxRateIndex4] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRateIndex4
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRateIndex4
		$I->comment("Exiting Action Group [goToTaxRateIndex4] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters2
		$I->comment("Exiting Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->comment("Entering Action Group [fillTaxIdentifierField3] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->fillField("#tax_rate_grid_filter_code", "TaxRate" . msq("defaultTaxRateWithLargeRate")); // stepKey: fillNameFilterFillTaxIdentifierField3
		$I->comment("Exiting Action Group [fillTaxIdentifierField3] AdminFillTaxIdentifierFilterOnTaxRateGridActionGroup");
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch2
		$I->waitForPageLoad(30); // stepKey: clickSearch2WaitForPageLoad
		$I->click("#tax_rate_grid_table tbody tr:nth-of-type(1)"); // stepKey: clickFirstRow2
		$I->waitForPageLoad(30); // stepKey: clickFirstRow2WaitForPageLoad
		$I->comment("Verify we see updated large tax rate on the tax rate form page");
		$I->seeInField("#code", "TaxRate" . msq("defaultTaxRateWithLargeRate")); // stepKey: seeRTaxIdentifier
		$I->seeOptionIsSelected("#tax_country_id", "United Kingdom"); // stepKey: seeCountry2
		$I->seeInField("#tax_postcode", "*"); // stepKey: seeZipCode
		$I->seeInField("#rate", "777.0000"); // stepKey: seeRate2
	}
}
