<?php
namespace Magento\AcceptanceTest\_SampleDataSuite\Backend;

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
 * @Title("MC-11823: Should be able to see Chaz Kangeroo Hoodie Product")
 * @Description("Should be able to see Chaz Kangeroo Hoodie Product created by CatalogSampleData module<h3>Test files</h3>Users/jessetran/Documents/magento2-sample-data/app/code/Magento/ConfigurableSampleData/Test/Mftf/Test/NavigateChazKangerooHoodieEntityTest.xml<br>")
 * @TestCaseId("MC-11823")
 * @group sampleData
 */
class NavigateChazKangerooHoodieEntityTestCest
{
	/**
	 * @Features({"ConfigurableSampleData"})
	 * @Stories({"Sample data"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function NavigateChazKangerooHoodieEntityTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/chaz-kangeroo-hoodie.html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductName] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->see("Chaz Kangeroo Hoodie", ".base"); // stepKey: seeProductNameAssertProductName
		$I->comment("Exiting Action Group [assertProductName] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("MH01", ".product.attribute.sku>.value"); // stepKey: seeProductSkuAssertProductSku
		$I->comment("Exiting Action Group [assertProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductPrice] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("$52.00", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceAssertProductPrice
		$I->comment("Exiting Action Group [assertProductPrice] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductImage] StorefrontAssertProductImagesOnProductPageActionGroup");
		$I->waitForElementNotVisible("#maincontent .fotorama__spinner--show", 30); // stepKey: waitGallerySpinnerDisappearAssertProductImage
		$I->seeElement("[data-gallery-role='gallery']"); // stepKey: seeProductGalleryAssertProductImage
		$I->waitForPageLoad(30); // stepKey: seeProductGalleryAssertProductImageWaitForPageLoad
		$I->seeElement("//*[@data-gallery-role='gallery' and not(contains(@class, 'fullscreen'))]//img[contains(@src, 'mh01-gray_main_1.jpg') and not(contains(@class, 'full'))]"); // stepKey: seeProductImageAssertProductImage
		$I->click("//*[@data-gallery-role='gallery' and not(contains(@class, 'fullscreen'))]//img[contains(@src, 'mh01-gray_main_1.jpg') and not(contains(@class, 'full'))]"); // stepKey: openFullscreenImageAssertProductImage
		$I->waitForPageLoad(30); // stepKey: waitForGalleryLoadedAssertProductImage
		$I->seeElement("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//img[contains(@src, 'mh01-gray_main_1.jpg') and contains(@class, 'full')]"); // stepKey: seeFullscreenProductImageAssertProductImage
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenImageAssertProductImage
		$I->waitForPageLoad(30); // stepKey: waitForGalleryDisappearAssertProductImage
		$I->comment("Exiting Action Group [assertProductImage] StorefrontAssertProductImagesOnProductPageActionGroup");
	}
}
