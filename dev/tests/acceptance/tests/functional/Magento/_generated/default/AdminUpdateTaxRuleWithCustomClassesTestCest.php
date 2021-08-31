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
 * @Title("MC-5820: Update tax rule, tax rule with custom classes")
 * @Description("Test log in to Update tax rule and Update tax rule with custom classes<h3>Test files</h3>app/code/Magento/Tax/Test/Mftf/Test/AdminUpdateTaxRuleWithCustomClassesTest.xml<br>")
 * @TestCaseId("MC-5820")
 * @group tax
 * @group mtf_migrated
 */
class AdminUpdateTaxRuleWithCustomClassesTestCest
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
		$I->createEntity("initialTaxRule", "hook", "defaultTaxRule", [], []); // stepKey: initialTaxRule
		$I->createEntity("taxRateWithZipRange", "hook", "defaultTaxRateWithZipRange", [], []); // stepKey: taxRateWithZipRange
		$I->createEntity("createCustomerTaxClass", "hook", "customerTaxClass", [], []); // stepKey: createCustomerTaxClass
		$I->createEntity("createProductTaxClass", "hook", "productTaxClass", [], []); // stepKey: createProductTaxClass
		$I->getEntity("customerTaxClass", "hook", "customerTaxClass", ["createCustomerTaxClass"], null); // stepKey: customerTaxClass
		$I->getEntity("productTaxClass", "hook", "productTaxClass", ["createProductTaxClass"], null); // stepKey: productTaxClass
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
		$I->deleteEntity("initialTaxRule", "hook"); // stepKey: deleteTaxRule
		$I->deleteEntity("taxRateWithZipRange", "hook"); // stepKey: deleteTaxRate
		$I->deleteEntity("createCustomerTaxClass", "hook"); // stepKey: deleteCustomerTaxClass
		$I->deleteEntity("createProductTaxClass", "hook"); // stepKey: deleteProductTaxClass
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
	 * @Stories({"Update tax rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Tax"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateTaxRuleWithCustomClassesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToTaxRuleIndex1] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRuleIndex1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRuleIndex1
		$I->comment("Exiting Action Group [goToTaxRuleIndex1] AdminTaxRuleGridOpenPageActionGroup");
		$I->comment("Entering Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters1
		$I->comment("Exiting Action Group [clickClearFilters1] AdminClearGridFiltersActionGroup");
		$I->fillField("#taxRuleGrid_filter_code", $I->retrieveEntityField('initialTaxRule', 'code', 'test')); // stepKey: fillTaxCodeSearch
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch1
		$I->waitForPageLoad(30); // stepKey: clickSearch1WaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: clickFirstRow1
		$I->waitForPageLoad(30); // stepKey: clickFirstRow1WaitForPageLoad
		$I->comment("Update tax rule with custom classes");
		$I->fillField("#code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: fillTaxRuleCode1
		$I->fillField("input[data-role='advanced-select-text']", $I->retrieveEntityField('taxRateWithZipRange', 'code', 'test')); // stepKey: fillTaxRateSearch
		$I->wait(5); // stepKey: waitForSearch
		$I->click("//*[@data-ui-id='tax-rate-form-fieldset-element-form-field-tax-rate']//span[.='" . $I->retrieveEntityField('taxRateWithZipRange', 'code', 'test') . "']"); // stepKey: clickSelectNeededItem
		$I->click("#details-summarybase_fieldset"); // stepKey: clickAdditionalSettings
		$I->waitForPageLoad(30); // stepKey: clickAdditionalSettingsWaitForPageLoad
		$I->scrollTo("#details-summarybase_fieldset", 0, -80); // stepKey: scrollToAdvancedSettings
		$I->waitForPageLoad(30); // stepKey: scrollToAdvancedSettingsWaitForPageLoad
		$I->wait(5); // stepKey: waitForAdditionalSettings
		$I->conditionalClick("//*[@id='tax_customer_class']/..//span[.='Retail Customer']", "//*[@id='tax_customer_class']/..//span[.='Retail Customer' and preceding-sibling::input[contains(@class, 'mselect-checked')]]", false); // stepKey: checkRetailCustomerTaxClass
		$I->conditionalClick("//*[@id='tax_product_class']/..//span[.='Taxable Goods']", "//*[@id='tax_product_class']/..//span[.='Taxable Goods' and preceding-sibling::input[contains(@class, 'mselect-checked')]]", false); // stepKey: checkTaxableGoodsTaxClass
		$I->click("//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productTaxClass', 'class_name', 'test') . "']"); // stepKey: clickSelectProductTaxClass
		$I->click("#save"); // stepKey: clickSaveTaxRule
		$I->waitForPageLoad(30); // stepKey: clickSaveTaxRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRuleSaved
		$I->comment("Verify we see success message");
		$I->see("You saved the tax rule.", "#messages"); // stepKey: seeAssertTaxRuleSuccessMessage
		$I->comment("Verify we see updated tax rule with default(from the above step) on the tax rule grid page");
		$I->comment("Entering Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: clickClearFiltersClickClearFilters2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClickClearFilters2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickClearFilters2
		$I->comment("Exiting Action Group [clickClearFilters2] AdminClearGridFiltersActionGroup");
		$I->fillField("#taxRuleGrid_filter_code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: fillTaxRuleCode2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearch2
		$I->waitForPageLoad(30); // stepKey: clickSearch2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTaxRuleSearch
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: clickFirstRow2
		$I->waitForPageLoad(30); // stepKey: clickFirstRow2WaitForPageLoad
		$I->comment("Verify we see updated tax rule with default on the tax rule form page");
		$I->seeInField("#code", "TaxRule" . msq("SimpleTaxRule")); // stepKey: seeInTaxRuleCode
		$I->seeElement("//span[contains(., '" . $I->retrieveEntityField('taxRateWithZipRange', 'code', 'test') . "') and preceding-sibling::input[contains(@class, 'mselect-checked')]]"); // stepKey: seeTaxRateSelected
		$I->click("#details-summarybase_fieldset"); // stepKey: clickAdditionalSettings1
		$I->waitForPageLoad(30); // stepKey: clickAdditionalSettings1WaitForPageLoad
		$I->scrollTo("#details-summarybase_fieldset", 0, -80); // stepKey: scrollToAdvancedSettings1
		$I->waitForPageLoad(30); // stepKey: scrollToAdvancedSettings1WaitForPageLoad
		$I->seeElement("//*[@id='tax_product_class']/..//span[.='" . $I->retrieveEntityField('productTaxClass', 'class_name', 'test') . "' and preceding-sibling::input[contains(@class, 'mselect-checked')]]"); // stepKey: seeProductTaxClass
		$I->seeElement("//*[@id='tax_customer_class']/..//span[.='Retail Customer' and preceding-sibling::input[contains(@class, 'mselect-checked')]]"); // stepKey: seeRetailCustomerTaxClass
		$I->seeElement("//*[@id='tax_product_class']/..//span[.='Taxable Goods' and preceding-sibling::input[contains(@class, 'mselect-checked')]]"); // stepKey: seeTaxableGoodsTaxClass
	}
}
