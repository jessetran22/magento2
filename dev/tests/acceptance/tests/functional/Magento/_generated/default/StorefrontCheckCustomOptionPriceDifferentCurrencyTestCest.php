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
 * @Title("MC-38926: Check custom option price with different currency")
 * @Description("Check custom option price with different currency on the product page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontCheckCustomOptionPriceDifferentCurrencyTest.xml<br>")
 * @TestCaseId("MC-38926")
 * @group catalog
 */
class StorefrontCheckCustomOptionPriceDifferentCurrencyTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$setCurrencyAllow = $I->magentoCLI("config:set currency/options/allow USD,EUR", 60); // stepKey: setCurrencyAllow
		$I->comment($setCurrencyAllow);
		$setAllowedCurrencyWebsitesForEURandUSD = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/allow USD,EUR", 60); // stepKey: setAllowedCurrencyWebsitesForEURandUSD
		$I->comment($setAllowedCurrencyWebsitesForEURandUSD);
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$createProductFields['price'] = "10";
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], $createProductFields); // stepKey: createProduct
		$I->updateEntity("createProduct", "hook", "productWithCheckbox",[]); // stepKey: updateProductWithOptions
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setCurrencyAllow = $I->magentoCLI("config:set currency/options/allow USD", 60); // stepKey: setCurrencyAllow
		$I->comment($setCurrencyAllow);
		$setAllowedCurrencyUSDWebsites = $I->magentoCLI("config:set --scope=websites --scope-code=base currency/options/allow USD", 60); // stepKey: setAllowedCurrencyUSDWebsites
		$I->comment($setAllowedCurrencyUSDWebsites);
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"Catalog"})
	 * @Stories({"Custom options"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckCustomOptionPriceDifferentCurrencyTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPageOnStorefront] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPageOnStorefront
		$I->comment("Exiting Action Group [openProductPageOnStorefront] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [checkPriceProductOptionUSD] AssertStorefrontCustomOptionCheckboxByPriceActionGroup");
		$I->seeElement("//label[contains(.,'OptionCheckbox')]/../div[@class='control']//span[@data-price-amount='12.3']"); // stepKey: checkPriceProductOptionCheckboxCheckPriceProductOptionUSD
		$I->comment("Exiting Action Group [checkPriceProductOptionUSD] AssertStorefrontCustomOptionCheckboxByPriceActionGroup");
		$I->comment("Entering Action Group [switchEURCurrency] StorefrontSwitchCurrencyActionGroup");
		$I->click("#switcher-currency-trigger"); // stepKey: openToggleSwitchEURCurrency
		$I->waitForPageLoad(30); // stepKey: openToggleSwitchEURCurrencyWaitForPageLoad
		$I->waitForElementVisible("//div[@id='switcher-currency-trigger']/following-sibling::ul//a[contains(text(), 'EUR')]", 30); // stepKey: waitForCurrencySwitchEURCurrency
		$I->waitForPageLoad(10); // stepKey: waitForCurrencySwitchEURCurrencyWaitForPageLoad
		$I->click("//div[@id='switcher-currency-trigger']/following-sibling::ul//a[contains(text(), 'EUR')]"); // stepKey: chooseCurrencySwitchEURCurrency
		$I->waitForPageLoad(10); // stepKey: chooseCurrencySwitchEURCurrencyWaitForPageLoad
		$I->see("EUR", "#switcher-currency-trigger span"); // stepKey: seeSelectedCurrencySwitchEURCurrency
		$I->comment("Exiting Action Group [switchEURCurrency] StorefrontSwitchCurrencyActionGroup");
		$I->comment("Entering Action Group [checkPriceProductOptionEUR] AssertStorefrontCustomOptionCheckboxByPriceActionGroup");
		$I->seeElement("//label[contains(.,'OptionCheckbox')]/../div[@class='control']//span[@data-price-amount='8.7']"); // stepKey: checkPriceProductOptionCheckboxCheckPriceProductOptionEUR
		$I->comment("Exiting Action Group [checkPriceProductOptionEUR] AssertStorefrontCustomOptionCheckboxByPriceActionGroup");
	}
}
